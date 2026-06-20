<?php

namespace App\Providers;
use App\Repositories\{
	UserRepository,
    EnquiryRepository,
};
use App\Repositories\Interfaces\{
	UserInterface,
    EnquiryInterface,
};
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
	/**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserInterface::class, UserRepository::class);
        $this->app->bind(EnquiryInterface::class, EnquiryRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}