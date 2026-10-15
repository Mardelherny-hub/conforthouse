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
        {--store : Save a private snapshot; by default output JSON to stdout only}';

    protected $description = 'Exporta evidencia técnica de solo lectura para informes ConfortHouse';

    public function handle(ConfortHouseEvidenceCollector $collector, ConfortHouseEvidenceSnapshots $snapshots): int
    {
        $rawFrom = $this->option('from');
        $rawTo = $this->option('to');
        if (($rawFrom === null) !== ($rawTo === null)) {
            $this->error('Provide both --from and --to, or neither.');
            return self::FAILURE;
        }

        $kind = 'explicit_report_window';
        if ($rawFrom === null) {
            $to = CarbonImmutable::now('UTC')->startOfDay();
            $from = $to->subDays(29);
            $kind = 'rolling_30_calendar_days_not_contractual_cycle';
        } else {
            $from = $this->parseDate($rawFrom);
            $to = $this->parseDate($rawTo);
            if ($from === null || $to === null) {
                $this->error('Dates must use YYYY-MM-DD.');
                return self::FAILURE;
            }
        }

        if ($from->greaterThan($to) || $from->diffInDays($to) > 62) {
            $this->error('Invalid date range (maximum 63 days inclusive).');
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

    private function parseDate(string $date): ?CarbonImmutable
    {
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            return null;
        }

        try {
            $parsed = CarbonImmutable::createFromFormat('!Y-m-d', $date, 'UTC');
            return $parsed && $parsed->format('Y-m-d') === $date ? $parsed : null;
        } catch (Throwable $e) {
            return null;
        }
    }
}
