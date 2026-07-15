<?php

namespace App\Console\Commands;

use App\Imports\ProductImport;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ImportProductsExcel extends Command
{
    protected $signature = 'products:import-excel {path : Absolute path to the xlsx file}';

    protected $description = 'Import products from an Excel file (used for large uploads in the background)';

    public function handle(): int
    {
        $path = $this->argument('path');

        ini_set('memory_limit', '512M');
        set_time_limit(0);

        if (!is_file($path)) {
            $this->error("File not found: {$path}");
            Log::error('products:import-excel file missing', ['path' => $path]);
            return self::FAILURE;
        }

        $this->info('Starting product import: '.$path);
        Log::info('products:import-excel started', ['path' => $path]);

        try {
            (new ProductImport)->import($path);
        } catch (\Throwable $e) {
            Log::error('products:import-excel failed', [
                'path' => $path,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            $this->error($e->getMessage());
            return self::FAILURE;
        }

        Log::info('products:import-excel finished', ['path' => $path]);
        $this->info('Product import finished.');

        return self::SUCCESS;
    }
}
