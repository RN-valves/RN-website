<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Console\Commands\ProductStatus;

Schedule::command(ProductStatus::class)->hourly();
