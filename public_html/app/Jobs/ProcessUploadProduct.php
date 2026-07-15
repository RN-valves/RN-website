<?php

namespace App\Jobs;

use App\Imports\ProductImport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessUploadProduct implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 900;

    public int $tries = 1;

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
            Log::info('Product Excel import finished', ['path' => $this->path]);
        } catch (\Throwable $e) {
            Log::error('Product Excel import failed', [
                'path' => $this->path,
                'message' => $e->getMessage(),
            ]);
            throw $e;
        }
    }
}
