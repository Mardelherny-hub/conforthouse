<?php

namespace Tests\Feature;

use App\Services\ConfortHouseEvidenceCollector;
use App\Services\ConfortHouseEvidenceSnapshots;
use Carbon\CarbonImmutable;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class ConfortHouseMaintenanceEvidenceTest extends TestCase
{
    private string $testDir;

    protected function setUp(): void
    {
        parent::setUp();
        $this->testDir = sys_get_temp_dir() . '/conforthouse-evidence-tests-' . bin2hex(random_bytes(8));
        mkdir($this->testDir, 0700, true);

        config()->set('database.default', 'sqlite');
        config()->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
            'foreign_key_constraints' => false,
        ]);
        DB::purge('sqlite');
        Schema::connection('sqlite')->create('properties', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('is_featured')->default(false);
            $table->unsignedInteger('operation_id')->nullable();
            $table->softDeletes();
        });

        config()->set('maintenance_evidence.snapshot_dir', $this->testDir . '/snapshots');
        config()->set('maintenance_evidence.spam_stats_path', $this->testDir . '/spam_stats.json');
        config()->set('maintenance_evidence.laravel_log_path', $this->testDir . '/laravel.log');
        config()->set('maintenance_evidence.enabled', false);
        config()->set('maintenance_evidence.read_token', '');
        Cache::clear();
    }

    protected function tearDown(): void
    {
        DB::disconnect('sqlite');
        $this->removeTree($this->testDir);
        parent::tearDown();
    }

    public function test_collects_current_counts_and_only_aggregated_logs_and_spam(): void
    {
        DB::table('properties')->insert([
            ['is_featured' => true, 'operation_id' => 1, 'deleted_at' => null],
            ['is_featured' => false, 'operation_id' => 1, 'deleted_at' => null],
            ['is_featured' => true, 'operation_id' => 2, 'deleted_at' => '2026-10-01 00:00:00'],
        ]);
        Cache::put('inmovilla_sync_last_run', CarbonImmutable::parse('2026-10-14 09:00:00 UTC'), 3600);
        Cache::put('inmovilla_last_sync_stats', ['total_processed' => 180, 'created' => 2, 'errors' => 0], 3600);
        file_put_contents($this->testDir . '/spam_stats.json', json_encode([
            '2026-09' => ['total' => 9, 'by_type' => ['honeypot' => 3], 'ips' => ['192.0.2.1']],
            '2026-10' => ['total' => 22, 'by_type' => ['time_check' => 4, 'recaptcha' => 7], 'ips' => ['198.51.100.9']],
        ]));
        file_put_contents($this->testDir . '/laravel.log', implode("\n", [
            '[2026-10-12 10:01:00] production.ERROR: Private customer name example@example.com',
            '[2026-10-14 05:20:00] production.WARNING: Private IP 192.0.2.5',
            '[2026-09-09 11:00:00] production.ERROR: Outside reporting period',
            '[2026-10-12 10:01:00] production.INFO: Normal',
        ]) . "\n");

        $result = app(ConfortHouseEvidenceCollector::class)->collect(
            CarbonImmutable::parse('2026-09-16', 'UTC'),
            CarbonImmutable::parse('2026-10-15', 'UTC'),
            'explicit_report_window'
        );

        $this->assertSame('redbyte.conforthouse.maintenance-evidence.v1', $result['schema_version']);
        $this->assertSame(2, $result['database_and_catalog']['counts_as_of_collection']['active']);
        $this->assertSame(1, $result['database_and_catalog']['counts_as_of_collection']['soft_deleted']);
        $this->assertSame(1, $result['database_and_catalog']['counts_as_of_collection']['featured_active']);
        $this->assertSame(180, $result['inmovilla']['last_sync_counters']['total_processed']);
        $this->assertSame(9, $result['spam']['calendar_months']['2026-09']['recorded_total']);
        $this->assertSame(22, $result['spam']['calendar_months']['2026-10']['recorded_total']);
        $this->assertSame(7, $result['spam']['calendar_months']['2026-10']['by_type']['recaptcha']);
        $this->assertSame(1, $result['laravel_log']['event_counts_in_requested_window']['ERROR']);
        $this->assertSame(1, $result['laravel_log']['event_counts_in_requested_window']['WARNING']);
        $this->assertSame('not_collected_here', $result['external_sources']['uptimerobot']['status']);
        $serialized = json_encode($result);
        $this->assertStringNotContainsString('example@example.com', $serialized);
        $this->assertStringNotContainsString('192.0.2.1', $serialized);
        $this->assertStringNotContainsString('192.0.2.5', $serialized);
        $this->assertStringNotContainsString('198.51.100.9', $serialized);
    }

    public function test_cli_creates_private_evidence_only_when_explicitly_requested(): void
    {
        $this->artisan('maintenance:evidence', [
            '--from' => '2026-09-16', '--to' => '2026-10-15',
        ])->assertExitCode(0);
        $this->assertFileDoesNotExist($this->testDir . '/snapshots/latest.json');

        $this->artisan('maintenance:evidence', [
            '--from' => '2026-09-16', '--to' => '2026-10-15', '--store' => true,
        ])->assertExitCode(0);
        $path = $this->testDir . '/snapshots/latest.json';
        $this->assertFileExists($path);
        $this->assertSame(0600, fileperms($path) & 0777);
        $data = json_decode(file_get_contents($path), true);
        $this->assertSame('explicit_report_window', $data['window']['kind']);
        $this->assertSame('conforthouse', $data['client']);
        $this->assertSame($data, app(ConfortHouseEvidenceSnapshots::class)->latest());
    }

    public function test_private_http_endpoint_denies_access_until_explicitly_enabled_and_authenticated(): void
    {
        $this->artisan('maintenance:evidence', ['--store' => true])->assertExitCode(0);
        $route = '/api/internal/maintenance-evidence/conforthouse';
        $validToken = str_repeat('S', 48);

        $this->getJson($route)->assertNotFound();
        config()->set('maintenance_evidence.enabled', true);
        config()->set('maintenance_evidence.read_token', 'weak');
        $this->getJson($route, ['X-RedByte-Evidence-Token' => 'weak'])->assertNotFound();

        config()->set('maintenance_evidence.read_token', $validToken);
        $this->getJson($route)->assertNotFound();
        $this->getJson($route, ['X-RedByte-Evidence-Token' => str_repeat('X', 48)])->assertNotFound();
        $response = $this->getJson($route, ['X-RedByte-Evidence-Token' => $validToken])->assertOk()
            ->assertJsonPath('client', 'conforthouse');
        $this->assertStringContainsString('no-store', $response->headers->get('Cache-Control'));
        $this->assertStringNotContainsString($validToken, $response->getContent());
    }

    public function test_invalid_periods_fail_without_creating_evidence(): void
    {
        $this->artisan('maintenance:evidence', [
            '--from' => '2026-10-01', '--store' => true,
        ])->assertExitCode(1);
        $this->artisan('maintenance:evidence', [
            '--from' => '2026-02-30', '--to' => '2026-03-01', '--store' => true,
        ])->assertExitCode(1);
        $this->artisan('maintenance:evidence', [
            '--from' => '2026-01-01', '--to' => '2026-10-15', '--store' => true,
        ])->assertExitCode(1);
        $this->assertFileDoesNotExist($this->testDir . '/snapshots/latest.json');
    }

    public function test_private_writer_rejects_public_path(): void
    {
        config()->set('maintenance_evidence.snapshot_dir', public_path());
        $this->expectException(\RuntimeException::class);
        app(ConfortHouseEvidenceSnapshots::class)->save([
            'schema_version' => 'redbyte.conforthouse.maintenance-evidence.v1',
            'client' => 'conforthouse',
        ]);
    }

    private function removeTree(string $path): void
    {
        if (!is_dir($path)) {
            return;
        }
        $items = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($path, \FilesystemIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::CHILD_FIRST
        );
        foreach ($items as $item) {
            $item->isDir() ? rmdir($item->getPathname()) : unlink($item->getPathname());
        }
        rmdir($path);
    }
}
