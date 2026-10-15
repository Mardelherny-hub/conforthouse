<?php

namespace App\Console\Commands;

use App\Services\ConfortHouseEvidenceCollector;
use App\Services\ConfortHouseEvidenceSnapshots;
use Carbon\CarbonImmutable;
use Illuminate\Console\Command;
use Throwable;

class ExportMaintenanceEvidence extends Command
{
    protected $signature = 'maintenance:evidence
        {--from= : Inclusive first date, YYYY-MM-DD (requires --to)}
        {--to= : Inclusive last date, YYYY-MM-DD (requires --from)}
        {--closed-cycle : Most recent closed 16th-to-15th contractual month (incompatible with --from/--to)}
        {--store : Save a private snapshot; by default output JSON to stdout only}';

    protected $description = 'Exporta evidencia técnica de solo lectura para informes ConfortHouse';

    public function handle(ConfortHouseEvidenceCollector $collector, ConfortHouseEvidenceSnapshots $snapshots): int
    {
        $rawFrom = $this->option('from');
        $rawTo = $this->option('to');
        $useClosedCycle = (bool) $this->option('closed-cycle');
        if (($rawFrom === null) !== ($rawTo === null) ||
            ($useClosedCycle && ($rawFrom !== null || $rawTo !== null))) {
            $this->error('Use both --from and --to, or --closed-cycle, but not together.');
            return self::FAILURE;
        }

        $timezone = 'Europe/Madrid';
        $today = CarbonImmutable::now($timezone)->startOfDay();
        $kind = 'explicit_report_window';
        if ($useClosedCycle) {
            // The contractual month ends on day 15; earliest eligible day is the 16th.
            $end = $today->day(15);
            if ($today->day < 16) {
                $end = $end->subMonthNoOverflow();
            }
            $to = $end;
            $from = $end->subMonthNoOverflow()->addDay();
            $kind = 'most_recent_closed_contract_cycle';
        } elseif ($rawFrom === null) {
            $to = $today;
            $from = $to->subDays(29);
            $kind = 'rolling_30_calendar_days_not_contractual_cycle';
        } else {
            $from = $this->parseDate($rawFrom, $timezone);
            $to = $this->parseDate($rawTo, $timezone);
            if ($from === null || $to === null) {
                $this->error('Dates must use YYYY-MM-DD.');
                return self::FAILURE;
            }
        }

        if ($from->greaterThan($to) || $from->diffInDays($to) > 62 || $to->greaterThan($today)) {
            $this->error('Invalid window (max 63 days, no future dates).');
            return self::FAILURE;
        }

        $evidence = $collector->collect($from, $to, $kind);
        if (!$this->option('store')) {
            $this->line(json_encode($evidence, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR));
            return self::SUCCESS;
        }

        try {
            $file = $snapshots->save($evidence);
        } catch (Throwable $e) {
            $this->error('Unable to save the private snapshot.');
            return self::FAILURE;
        }

        $this->info("Private evidence snapshot saved: {$file}");
        return self::SUCCESS;
    }

    private function parseDate(string $date, string $timezone): ?CarbonImmutable
    {
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            return null;
        }

        try {
            $parsed = CarbonImmutable::createFromFormat('!Y-m-d', $date, $timezone);
            return $parsed && $parsed->format('Y-m-d') === $date ? $parsed : null;
        } catch (Throwable $e) {
            return null;
        }
    }
}
