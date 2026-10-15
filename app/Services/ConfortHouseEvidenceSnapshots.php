<?php

namespace App\Services;

use RuntimeException;

class ConfortHouseEvidenceSnapshots
{
    /** Writes only to private storage; never to public/, a URL or the database. */
    public function save(array $payload): string
    {
        $directory = (string) config('maintenance_evidence.snapshot_dir');
        if ($directory === '' || is_link($directory)) {
            throw new RuntimeException('Invalid evidence directory');
        }
        if (!is_dir($directory) && !@mkdir($directory, 0700, true) && !is_dir($directory)) {
            throw new RuntimeException('Cannot create private evidence directory');
        }
        $root = realpath($directory);
        $publicRoot = realpath(public_path());
        if (!$root || !$publicRoot || $root === $publicRoot || str_starts_with($root, $publicRoot . DIRECTORY_SEPARATOR)) {
            throw new RuntimeException('Evidence directory cannot be public');
        }

        $json = json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR) . "\n";
        // Single replaceable snapshot. Do not accumulate monthly JSON files on IONOS.
        $name = 'latest.json';
        $this->atomicWrite($root . DIRECTORY_SEPARATOR . $name, $json);

        return $name;
    }

    public function latest(): ?array
    {
        $directory = (string) config('maintenance_evidence.snapshot_dir');
        $path = $directory . DIRECTORY_SEPARATOR . 'latest.json';
        if (!is_file($path) || is_link($path) || !is_readable($path)) {
            return null;
        }
        $bytes = @filesize($path);
        if ($bytes === false || $bytes > 256 * 1024) {
            return null;
        }

        $raw = @file_get_contents($path);
        $snapshot = $raw === false ? null : json_decode($raw, true);
        if (!is_array($snapshot) ||
            ($snapshot['schema_version'] ?? null) !== 'redbyte.maintenance-evidence.v1' ||
            ($snapshot['client'] ?? null) !== 'conforthouse') {
            return null;
        }
        return $snapshot;
    }

    private function atomicWrite(string $destination, string $contents): void
    {
        $temporary = $destination . '.tmp-' . bin2hex(random_bytes(8));
        try {
            if (@file_put_contents($temporary, $contents, LOCK_EX) !== strlen($contents)) {
                throw new RuntimeException('Cannot write private evidence');
            }
            @chmod($temporary, 0600);
            if (!@rename($temporary, $destination)) {
                throw new RuntimeException('Cannot publish private evidence snapshot');
            }
        } finally {
            if (is_file($temporary)) {
                @unlink($temporary);
            }
        }
    }
}
