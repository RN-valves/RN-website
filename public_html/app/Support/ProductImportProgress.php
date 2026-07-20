<?php

namespace App\Support;

use Illuminate\Support\Facades\File;

class ProductImportProgress
{
    public static function path(?string $token = null): string
    {
        $dir = storage_path('app/imports');
        File::ensureDirectoryExists($dir, 0775, true);

        return $dir.'/product_import_'.($token ?: 'latest').'.json';
    }

    public static function write(array $data, ?string $token = null): void
    {
        $payload = array_merge(self::read($token) ?? [], $data, [
            'updated_at' => now()->toIso8601String(),
        ]);

        $total = (int) ($payload['total'] ?? 0);
        $processed = (int) ($payload['processed'] ?? 0);
        $startedAt = $payload['started_at'] ?? null;

        $payload['percent'] = $total > 0
            ? (int) min(100, floor(($processed / $total) * 100))
            : (($payload['status'] ?? '') === 'done' ? 100 : 0);

        $payload['eta_seconds'] = null;
        $payload['elapsed_seconds'] = null;

        if ($startedAt) {
            $elapsed = max(0, now()->diffInSeconds(\Carbon\Carbon::parse($startedAt)));
            $payload['elapsed_seconds'] = $elapsed;

            if ($processed > 0 && $total > $processed && $elapsed > 0) {
                $rate = $processed / $elapsed;
                $payload['eta_seconds'] = (int) ceil(($total - $processed) / max($rate, 0.0001));
            } elseif (($payload['status'] ?? '') === 'done') {
                $payload['eta_seconds'] = 0;
            }
        }

        File::put(self::path($token), json_encode($payload, JSON_PRETTY_PRINT));

        // Always mirror latest so the page can poll without a token.
        if ($token) {
            File::put(self::path('latest'), json_encode($payload, JSON_PRETTY_PRINT));
        }
    }

    public static function read(?string $token = null): ?array
    {
        $file = self::path($token ?: 'latest');
        if (!is_file($file)) {
            return null;
        }

        $decoded = json_decode((string) File::get($file), true);

        return is_array($decoded) ? $decoded : null;
    }

    public static function countExcelDataRows(string $absolutePath): int
    {
        try {
            $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile($absolutePath);
            $info = $reader->listWorksheetInfo($absolutePath);
            $totalRows = (int) ($info[0]['totalRows'] ?? 0);

            // First row is the heading row.
            return max(0, $totalRows - 1);
        } catch (\Throwable $e) {
            return 0;
        }
    }

    public static function formatDuration(?int $seconds): string
    {
        if ($seconds === null) {
            return '—';
        }

        $seconds = max(0, $seconds);
        if ($seconds < 60) {
            return $seconds.' sec';
        }

        $minutes = intdiv($seconds, 60);
        $remain = $seconds % 60;
        if ($minutes < 60) {
            return $remain > 0 ? "{$minutes} min {$remain} sec" : "{$minutes} min";
        }

        $hours = intdiv($minutes, 60);
        $mins = $minutes % 60;

        return $mins > 0 ? "{$hours} hr {$mins} min" : "{$hours} hr";
    }
}
