<?php

return [
    // Everything is opt-in. The endpoint is disabled until explicitly configured.
    'enabled' => env('REDBYTE_EVIDENCE_ENABLED', false),
    'schedule_enabled' => env('REDBYTE_EVIDENCE_SCHEDULE_ENABLED', false),
    'read_token' => env('REDBYTE_EVIDENCE_READ_TOKEN', ''),
    'timezone' => 'Europe/Madrid',
    'snapshot_dir' => storage_path('app/private/report-evidence/conforthouse'),
    'spam_stats_path' => storage_path('app/spam_stats.json'),
    'laravel_log_path' => storage_path('logs/laravel.log'),
    // Metadata of stored Inmovilla XML downloads; never read XML contents here.
    'inmovilla_xml_directory' => storage_path('app/inmovilla'),
    'max_inmovilla_archive_entries' => 50000,
    'max_log_scan_bytes' => 250 * 1024 * 1024,
];
