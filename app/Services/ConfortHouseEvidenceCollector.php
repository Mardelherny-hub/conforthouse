<?php

namespace App\Services;

use App\Models\Property;
use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Throwable;

/**
 * Only SELECTs, cache reads and private-file reads. No raw personal data or logs leave the server.
 * A snapshot is not evidence that every day in a reporting period was healthy.
 */
class ConfortHouseEvidenceCollector
{
    public function collect(CarbonImmutable $from, CarbonImmutable $to, string $periodKind): array
    {
        $now = CarbonImmutable::now('UTC');

        return [
            'schema_version' => 'redbyte.conforthouse.maintenance-evidence.v1',
            'client' => 'conforthouse',
            'collected_at_utc' => $now->toIso8601String(),
            'window' => [
                'from_date' => $from->toDateString(),
                'through_date' => $to->toDateString(),
                'kind' => $periodKind,
                'completeness' => 'partial_snapshot_and_available_logs',
            ],
            'database_and_catalog' => $this->databaseAndCatalog(),
            'inmovilla' => $this->inmovillaCache(),
            'spam' => $this->spamStatistics($from, $to),
            'laravel_log' => $this->laravelLog($from, $to),
            'disk' => $this->diskSnapshot(),
            'external_sources' => [
                'uptimerobot' => [
                    'status' => 'not_collected_here',
                    'monitor' => 'https://rbconforthouse.com/health',
                    'note' => 'Fetch external incidents and uptime for the exact report dates from UptimeRobot.',
                ],
                'interventions' => [
                    'status' => 'not_collected_here',
                    'note' => 'Cross-check support tickets, deployments and completed work separately.',
                ],
            ],
            'limits' => [
                'Current counts, cache values, disk and file sizes are observations at collection time.',
                'The source log may be rotated or incomplete; zero recorded errors is not proof of zero incidents.',
                'Antispam file aggregates calendar months, not arbitrary report-day ranges.',
                'Do not infer historical uptime, completed backups, or root cause from this snapshot.',
                'This evidence JSON is NOT the ReportDraftService import schema.',
            ],
        ];
    }

    private function databaseAndCatalog(): array
    {
        try {
            DB::selectOne('SELECT 1');
        } catch (Throwable $e) {
            return ['status' => 'unavailable', 'counts' => null];
        }

        try {
            $byOperation = Property::query()
                ->select('operation_id', DB::raw('count(*) as total'))
                ->groupBy('operation_id')
                ->pluck('total', 'operation_id')->toArray();

            return [
                'status' => 'reachable',
                'counts_as_of_collection' => [
                    'active' => Property::query()->count(),
                    'soft_deleted' => Property::onlyTrashed()->count(),
                    'featured_active' => Property::query()->where('is_featured', true)->count(),
                    'by_operation' => array_map('intval', $byOperation),
                ],
            ];
        } catch (Throwable $e) {
            return ['status' => 'reachable', 'counts' => null, 'counts_status' => 'unavailable'];
        }
    }

    private function inmovillaCache(): array
    {
        try {
            $lastRun = Cache::get('inmovilla_sync_last_run');
            $lastStats = Cache::get('inmovilla_last_sync_stats');

            $lastRunAt = null;
            if ($lastRun instanceof CarbonInterface) {
                $lastRunAt = CarbonImmutable::instance($lastRun)->utc()->toIso8601String();
            } elseif (is_string($lastRun) && $lastRun !== '') {
                try {
                    $lastRunAt = CarbonImmutable::parse($lastRun)->utc()->toIso8601String();
                } catch (Throwable $e) {
                    // Cache contents are not guaranteed to be well formed.
                }
            }

            $stats = null;
            if (is_array($lastStats)) {
                $stats = [];
                foreach (['total_processed', 'created', 'updated', 'errors'] as $key) {
                    $stats[$key] = isset($lastStats[$key]) && is_numeric($lastStats[$key])
                        ? (int) $lastStats[$key] : null;
                }
            }

            return [
                'source' => 'application_cache',
                'last_sync_at_utc' => $lastRunAt,
                'last_sync_counters' => $stats,
                'note' => 'Cached entries have a limited TTL; missing entries do not establish failed synchronization.',
            ];
        } catch (Throwable $e) {
            return ['status' => 'unavailable', 'source' => 'application_cache'];
        }
    }

    private function spamStatistics(CarbonImmutable $from, CarbonImmutable $to): array
    {
        $path = config('maintenance_evidence.spam_stats_path');
        if (!is_file($path) || !is_readable($path)) {
            return ['status' => 'missing', 'source' => 'spam_stats.json', 'calendar_months' => []];
        }
        $size = @filesize($path);
        if ($size === false || $size > 1024 * 1024) {
            return ['status' => 'unavailable_or_too_large', 'source' => 'spam_stats.json'];
        }

        $raw = @file_get_contents($path);
        $data = $raw === false ? null : json_decode($raw, true);
        if (!is_array($data)) {
            return ['status' => 'invalid', 'source' => 'spam_stats.json'];
        }

        $months = [];
        $month = $from->startOfMonth();
        while ($month->lessThanOrEqualTo($to)) {
            $key = $month->format('Y-m');
            $item = $data[$key] ?? null;
            if (is_array($item)) {
                $byType = is_array($item['by_type'] ?? null) ? $item['by_type'] : [];
                $months[$key] = [
                    'recorded_total' => max(0, (int) ($item['total'] ?? 0)),
                    'by_type' => [
                        'user_agent' => max(0, (int) ($byType['user_agent'] ?? 0)),
                        'honeypot' => max(0, (int) ($byType['honeypot'] ?? 0)),
                        'time_check' => max(0, (int) ($byType['time_check'] ?? 0)),
                        'recaptcha' => max(0, (int) ($byType['recaptcha'] ?? 0)),
                    ],
                    'ip_sample_size_capped_at_50' => is_array($item['ips'] ?? null)
                        ? min(50, count($item['ips'])) : null,
                ];
            } else {
                $months[$key] = null;
            }
            $month = $month->addMonth();
        }

        return [
            'status' => 'available',
            'source' => 'spam_stats.json',
            'calendar_months' => $months,
            'note' => 'Counters are monthly and omit campaign blocks that do not call recordSpamAttempt. No IP values exported.',
        ];
    }

    private function laravelLog(CarbonImmutable $from, CarbonImmutable $to): array
    {
        $path = config('maintenance_evidence.laravel_log_path');
        if (!is_file($path) || !is_readable($path)) {
            return ['status' => 'missing', 'source' => 'current_laravel_log_only'];
        }

        $size = @filesize($path);
        if ($size === false) {
            return ['status' => 'unreadable', 'source' => 'current_laravel_log_only'];
        }

        $result = [
            'status' => 'available',
            'source' => 'current_laravel_log_only',
            'size_bytes_at_collection' => $size,
            'size_over_50_mb' => $size > 50 * 1024 * 1024,
            'modified_at_utc' => null,
            'event_counts_in_requested_window' => null,
            'coverage' => 'unverified_may_be_rotated',
        ];
        if (($modified = @filemtime($path)) !== false) {
            $result['modified_at_utc'] = gmdate('c', $modified);
        }

        if ($size > (int) config('maintenance_evidence.max_log_scan_bytes')) {
            $result['status'] = 'scan_skipped_size_limit';
            return $result;
        }

        $counts = ['EMERGENCY' => 0, 'ALERT' => 0, 'CRITICAL' => 0, 'ERROR' => 0, 'WARNING' => 0];
        try {
            $file = new \SplFileObject($path, 'r');
            while (!$file->eof()) {
                $line = $file->fgets();
                if (preg_match('/^\[(\d{4}-\d{2}-\d{2}) \d{2}:\d{2}:\d{2}\] [^.\s]+\.(EMERGENCY|ALERT|CRITICAL|ERROR|WARNING):/', $line, $matches)) {
                    if ($matches[1] >= $from->toDateString() && $matches[1] <= $to->toDateString()) {
                        $counts[$matches[2]]++;
                    }
                }
            }
            $result['event_counts_in_requested_window'] = $counts;
        } catch (Throwable $e) {
            $result['status'] = 'scan_failed';
        }
        return $result;
    }

    private function diskSnapshot(): array
    {
        $total = @disk_total_space(base_path());
        $free = @disk_free_space(base_path());

        return [
            'filesystem_total_bytes_now' => $total === false ? null : (int) $total,
            'filesystem_free_bytes_now' => $free === false ? null : (int) $free,
            'note' => 'Shared hosting filesystem capacity, NOT the IONOS account quota or its historical use.',
        ];
    }
}
