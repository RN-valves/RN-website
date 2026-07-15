<?php

namespace App\Jobs;

use App\Imports\ProductImport;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

class ProcessUploadProduct
{
    use Dispatchable;

    public function __construct(public string $path)
    {
    }

    public function handle(): void
    {
        ini_set('memory_limit', '512M');
        set_time_limit(900);

        try {
            if (!is_file($this->path)) {
                Log::error('Product Excel import skipped: file missing', ['path' => $this->path]);
                return;
            }

            (new ProductImport)->import($this->path);
        } catch (\Throwable $e) {
            Log::error('Product Excel import failed', [
                'path' => $this->path,
                'message' => $e->getMessage(),
            ]);
            // Do not rethrow afterResponse — response is already sent to the browser.
        }
    }
}
