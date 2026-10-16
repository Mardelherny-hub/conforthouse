<?php

namespace App\Services;

use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\DB;
use Throwable;

/**
 * Bounded, read-only investigation of the actual daily Inmovilla command.
 * Runs only while creating the private monthly snapshot; never in the HTTP route.
 */
class ConfortHouseInmovillaHistory
{
    private const EVENTS = [
        'daily_completion' => 'Actualización diaria Inmovilla completada',
        'scheduler_completion' => 'Actualización automática Inmovilla completada',
        'scheduler_failure' => 'Error en actualización automática Inmovilla',
        'daily_failure' => 'Error en actualización Inmovilla',
        'download_failure' => 'Error descargando XML de Inmovilla',
        'individual_property_error' => 'Error importando propiedad',
    ];

    public function collect(CarbonImmutable $from, CarbonImmutable $to): array
    {
        $timezone = (string) config('maintenance_evidence.timezone', 'Europe/Madrid');
        $from = $from->setTimezone($timezone)->startOfDay();
        $until = $to->setTimezone($timezone)->startOfDay()->addDay();

        $archived = $this->archivedDownloads($from, $until, $timezone);
        $logs = $this->logExecutions($from, $until, $timezone);
        $observedCompletionDates = $logs['events']['daily_completion']['dates'] ?? [];
        $unseen = [];

        // Only return missing dates as an evidence-coverage statement, not failed jobs.
        if ($logs['status'] === 'available') {
            for ($day = $from; $day->lessThan($until); $day = $day->addDay()) {
                $date = $day->toDateString();
                if (! in_array($date, $observedCompletionDates, true)) {
                    $unseen[] = $date;
                }
            }
        }

        $latestPropertyUpdate = null;
        $inmovillaReferenceCount = null;
        try {
            $latestPropertyUpdate = DB::table('properties')->whereNull('deleted_at')->max('updated_at');
            $inmovillaReferenceCount = DB::table('properties')->whereNull('deleted_at')
                ->whereNotNull('cod_ofer')->count();
        } catch (Throwable $exception) {
            // The monthly source can still be read when the catalog query fails.
        }

        return [
            'status' => $archived['status'] === 'available' && $logs['status'] === 'available'
                ? 'available_with_partial_log_coverage' : 'partial',
            'timezone' => $timezone,
            'schedule_declared' => [
                'command' => 'inmovilla:update',
                'clock' => '03:00',
                'timezone' => 'America/Argentina/Buenos_Aires',
                'evidence_type' => 'laravel_schedule_declaration_not_proof_of_ionos_cron',
            ],
            'archived_xml_downloads' => $archived,
            'application_log' => $logs,
            'dates_without_a_completion_entry_in_available_log' => $unseen,
            'catalog_snapshot' => [
                'inmovilla_referenced_active_properties' => $inmovillaReferenceCount === null
                    ? null : (int) $inmovillaReferenceCount,
                'latest_property_updated_at_app_timezone' => is_string($latestPropertyUpdate)
                    ? $latestPropertyUpdate : null,
                'app_timezone' => (string) config('app.timezone', 'UTC'),
                'observation_type' => 'point_in_time_not_monthly_sync_count',
            ],
            'interpretation' => [
                'XML timestamps are filesystem modification times, not verified success of the import.',
                'Daily completion messages confirm only the command reported success; individual record outcomes require separate evidence.',
                'Log coverage is limited to the current Laravel log and may omit rotated events.',
                'Dates without log entries are not proof that the scheduled task failed or did not run.',
                'No source file names, IDs of properties, raw logs, IP addresses, or credentials are exposed.',
            ],
        ];
    }

    private function archivedDownloads(CarbonImmutable $from, CarbonImmutable $until, string $timezone): array
    {
        $directory = (string) config('maintenance_evidence.inmovilla_xml_directory', '');
        if ($directory === '' || is_link($directory) || ! is_dir($directory) || ! is_readable($directory)) {
            return ['status' => 'missing_or_unreadable', 'count' => null, 'dates' => [], 'first_at_utc' => null, 'last_at_utc' => null];
        }
        $entries = @scandir($directory);
        $limit = (int) config('maintenance_evidence.max_inmovilla_archive_entries', 50000);
        if (! is_array($entries) || count($entries) > $limit) {
            return ['status' => 'scan_limit_or_unreadable', 'count' => null, 'dates' => [], 'first_at_utc' => null, 'last_at_utc' => null];
        }
        $days = [];
        $count = 0;
        $first = null;
        $last = null;
        foreach ($entries as $entry) {
            if (! preg_match('/^inmovilla-\d{4}-\d{2}-\d{2}-\d{6}\.xml$/D', $entry)) {
                continue;
            }
            $path = $directory.DIRECTORY_SEPARATOR.$entry;
            if (is_link($path) || ! is_file($path) || ($timestamp = @filemtime($path)) === false ||
                $timestamp < $from->timestamp || $timestamp >= $until->timestamp) {
                continue;
            }
            $count++;
            $date = CarbonImmutable::createFromTimestamp($timestamp, $timezone)->toDateString();
            $days[$date] = ($days[$date] ?? 0) + 1;
            $first = $first === null ? $timestamp : min($first, $timestamp);
            $last = $last === null ? $timestamp : max($last, $timestamp);
        }
        ksort($days);

        return [
            'status' => 'available',
            'source' => 'private_inmovilla_download_archive_file_metadata',
            'count' => $count,
            'distinct_days' => count($days),
            'dates' => array_keys($days),
            'first_at_utc' => $first === null ? null : gmdate('Y-m-d\TH:i:s\Z', $first),
            'last_at_utc' => $last === null ? null : gmdate('Y-m-d\TH:i:s\Z', $last),
        ];
    }

    private function logExecutions(CarbonImmutable $from, CarbonImmutable $until, string $timezone): array
    {
        $path = (string) config('maintenance_evidence.laravel_log_path');
        $size = $path !== '' && is_file($path) && ! is_link($path) ? @filesize($path) : false;
        if ($size === false || ! is_readable($path)) {
            return ['status' => 'missing_or_unreadable', 'events' => []];
        }
        if ($size > (int) config('maintenance_evidence.max_log_scan_bytes', 250 * 1024 * 1024)) {
            return ['status' => 'scan_skipped_size_limit', 'events' => []];
        }
        $handle = @fopen($path, 'rb');
        if ($handle === false) {
            return ['status' => 'missing_or_unreadable', 'events' => []];
        }
        $events = [];
        foreach (self::EVENTS as $name => $term) {
            $events[$name] = ['count' => 0, 'dates' => [], 'first_at_utc' => null, 'last_at_utc' => null];
        }
        try {
            $logTimezone = (string) config('app.timezone', 'UTC');
            $startLogClock = $from->setTimezone($logTimezone)->format('Y-m-d H:i:s');
            $untilLogClock = $until->setTimezone($logTimezone)->format('Y-m-d H:i:s');
            $timestamps = [];
            $byDate = [];
            while (($line = fgets($handle, 32768)) !== false) {
                if (! str_starts_with($line, '[')) {
                    continue;
                }
                $type = null;
                foreach (self::EVENTS as $name => $term) {
                    if (str_contains($line, $term)) {
                        $type = $name;
                        break;
                    }
                }
                if ($type === null || ! preg_match('/^\[(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})\]/', $line, $matched) ||
                    $matched[1] < $startLogClock || $matched[1] >= $untilLogClock) {
                    continue;
                }
                $instant = CarbonImmutable::createFromFormat('!Y-m-d H:i:s', $matched[1], $logTimezone);
                if ($instant === false) {
                    continue;
                }
                $eventDate = $instant->setTimezone($timezone)->toDateString();
                $events[$type]['count']++;
                $byDate[$type][$eventDate] = true;
                $timestamp = $instant->timestamp;
                $timestamps[$type]['first'] = isset($timestamps[$type]['first'])
                    ? min($timestamps[$type]['first'], $timestamp) : $timestamp;
                $timestamps[$type]['last'] = isset($timestamps[$type]['last'])
                    ? max($timestamps[$type]['last'], $timestamp) : $timestamp;
            }
            foreach (self::EVENTS as $type => $term) {
                $days = array_keys($byDate[$type] ?? []);
                sort($days);
                $events[$type]['dates'] = $days;
                $events[$type]['first_at_utc'] = isset($timestamps[$type]['first'])
                    ? gmdate('Y-m-d\TH:i:s\Z', $timestamps[$type]['first']) : null;
                $events[$type]['last_at_utc'] = isset($timestamps[$type]['last'])
                    ? gmdate('Y-m-d\TH:i:s\Z', $timestamps[$type]['last']) : null;
            }
        } catch (Throwable $exception) {
            return ['status' => 'scan_failed', 'events' => []];
        } finally {
            fclose($handle);
        }

        return [
            'status' => 'available',
            'source' => 'current_laravel_log_only',
            'bytes_scanned' => $size,
            'events' => $events,
        ];
    }
}
