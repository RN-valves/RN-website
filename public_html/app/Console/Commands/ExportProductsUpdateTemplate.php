<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Rap2hpoutre\FastExcel\FastExcel;

class ExportProductsUpdateTemplate extends Command
{
    protected $signature = 'products:export-update-template {output : Absolute path for the xlsx output file}';

    protected $description = 'Build the product Update Template Excel in the background';

    public function handle(): int
    {
        $output = $this->argument('output');

        ini_set('memory_limit', '512M');
        set_time_limit(0);

        File::ensureDirectoryExists(dirname($output), 0775, true);

        $pending = $output.'.pending';
        File::put($pending, (string) time());

        Log::info('products:export-update-template started', ['output' => $output]);
        $this->info('Exporting update template…');

        try {
            $rows = function () {
                $query = Product::query()
                    ->join('product_attributes', 'product_attributes.product_id', '=', 'products.id')
                    ->join('subcategories', 'subcategories.id', '=', 'products.subcategory_id')
                    ->join('categories', 'categories.id', '=', 'products.category_id')
                    ->select([
                        'categories.name as category',
                        'subcategories.name as subcategory',
                        'products.name',
                        'products.content_id',
                        'products.brand',
                        'products.material',
                        'products.color_name',
                        'products.color_group_id',
                        'products.packaging_group_id',
                        'products.product_combo_id',
                        'products.product_size_id',
                        'products.article',
                        'products.sku_code',
                        'products.size',
                        'products.hsn',
                        'products.image',
                        'products.in_mrp',
                        'products.in_selling',
                        'products.in_v1_mrp',
                        'products.oth_mrp',
                        'products.oth_selling',
                        'products.oth_v1_mrp',
                        'products.title',
                        'products.keywords',
                        'products.description',
                        'products.search_keywords',
                        'products.status',
                        'products.is_visible_website',
                        'products.new_arrival',
                        'products.is_visible_api',
                        'products.is_featured',
                        'products.is_full_turn',
                        'products.full_turn_code',
                        'products.sale_type',
                        'product_attributes.ctn_pcs',
                        'product_attributes.mid_ctn_pcs',
                        'product_attributes.inner_pcs',
                        'product_attributes.stock_pcs',
                        'product_attributes.only_product_wt_gm',
                        'product_attributes.product_length',
                        'product_attributes.product_breadth',
                        'product_attributes.product_height',
                        'product_attributes.product_lbh_weight_gm',
                        'product_attributes.mid_ctn_lbh_weight_kg',
                        'product_attributes.master_ctn_lbh_weight_kg',
                        'product_attributes.residential_warranty',
                        'product_attributes.commercial_warranty',
                        'product_attributes.amazon_link',
                        'product_attributes.flipkart_link',
                        'product_attributes.short_description',
                        'product_attributes.video_url',
                    ]);

                foreach ($query->cursor() as $product) {
                    yield $product;
                }
            };

            (new FastExcel($rows()))->export($output);
        } catch (\Throwable $e) {
            File::delete($pending);
            Log::error('products:export-update-template failed', [
                'output' => $output,
                'message' => $e->getMessage(),
            ]);
            $this->error($e->getMessage());
            return self::FAILURE;
        }

        File::delete($pending);
        Log::info('products:export-update-template finished', ['output' => $output]);
        $this->info('Export finished: '.$output);

        return self::SUCCESS;
    }
}
