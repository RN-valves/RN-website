<?php

namespace App\Console\Commands;

use App\Imports\ProductImport;
use App\Support\ProductImportProgress;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ImportProductsExcel extends Command
{
    protected $signature = 'products:import-excel {path : Absolute path to the xlsx file} {--token= : Progress token for UI polling}';

    protected $description = 'Import products from an Excel file (used for large uploads in the background)';

    public function handle(): int
    {
        $path = $this->argument('path');
        $token = (string) ($this->option('token') ?: 'latest');

        ini_set('memory_limit', '512M');
        set_time_limit(0);

        if (!is_file($path)) {
            $this->error("File not found: {$path}");
            Log::error('products:import-excel file missing', ['path' => $path]);
            ProductImportProgress::write([
                'status' => 'failed',
                'message' => 'Import file not found.',
                'processed' => 0,
                'total' => 0,
            ], $token);

            return self::FAILURE;
        }

        $total = ProductImportProgress::countExcelDataRows($path);

        ProductImportProgress::write([
            'status' => 'running',
            'message' => 'Import started…',
            'file' => basename($path),
            'processed' => 0,
            'total' => $total,
            'started_at' => now()->toIso8601String(),
            'finished_at' => null,
            'error' => null,
        ], $token);

        $this->info('Starting product import: '.$path.' ('.$total.' rows)');
        Log::info('products:import-excel started', ['path' => $path, 'total' => $total, 'token' => $token]);

        try {
            (new ProductImport($token, $total))->import($path);
        } catch (\Throwable $e) {
            Log::error('products:import-excel failed', [
                'path' => $path,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            ProductImportProgress::write([
                'status' => 'failed',
                'message' => 'Import failed: '.$e->getMessage(),
                'error' => $e->getMessage(),
                'finished_at' => now()->toIso8601String(),
            ], $token);
            $this->error($e->getMessage());

            return self::FAILURE;
        }

        ProductImportProgress::write([
            'status' => 'done',
            'message' => 'Import finished successfully.',
            'processed' => $total > 0 ? $total : (ProductImportProgress::read($token)['processed'] ?? 0),
            'total' => $total,
            'finished_at' => now()->toIso8601String(),
            'eta_seconds' => 0,
        ], $token);

        Log::info('products:import-excel finished', ['path' => $path, 'token' => $token]);
        $this->info('Product import finished.');

        return self::SUCCESS;
    }
}
