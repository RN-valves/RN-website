<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Rap2hpoutre\FastExcel\FastExcel;

class ExportProductImagesUpdateTemplate extends Command
{
    protected $signature = 'product-images:export-update-template {output : Absolute path for the xlsx output file}';

    protected $description = 'Build the product images Update Template Excel in the background';

    public function handle(): int
    {
        $output = $this->argument('output');

        ini_set('memory_limit', '512M');
        set_time_limit(0);

        File::ensureDirectoryExists(dirname($output), 0775, true);

        $pending = $output.'.pending';
        File::put($pending, (string) time());

        Log::info('product-images:export-update-template started', ['output' => $output]);
        $this->info('Exporting product images update template...');

        try {
            $rows = function () {
                $query = DB::table('product_images')
                    ->join('products', 'products.id', '=', 'product_images.product_id')
                    ->select('products.article', 'product_images.sku_code', 'product_images.image')
                    ->orderBy('product_images.id');

                foreach ($query->cursor() as $row) {
                    yield [
                        'article' => $row->article,
                        'sku_code' => $row->sku_code,
                        'image' => $row->image,
                    ];
                }
            };

            (new FastExcel($rows()))->export($output);
        } catch (\Throwable $e) {
            File::delete($pending);
            Log::error('product-images:export-update-template failed', [
                'output' => $output,
                'message' => $e->getMessage(),
            ]);
            $this->error($e->getMessage());

            return self::FAILURE;
        }

        File::delete($pending);
        Log::info('product-images:export-update-template finished', ['output' => $output]);
        $this->info('Export finished: '.$output);

        return self::SUCCESS;
    }
}
