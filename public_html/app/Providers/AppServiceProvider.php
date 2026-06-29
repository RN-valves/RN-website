<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\Relations\Relation;
use App\Models\{
    Enquiry,
    User,
    Category,
    Subcategory,
    Product
};
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;
use App\Services\OpenAIService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(OpenAIService::class, function ($app) {
            return new OpenAIService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    protected $policies = [
        //'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    public function boot(): void
    {
        if (app()->environment('production') || config('app.env') === 'production') {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        //$this->registerPolicies();
        /*if (! $this->app->routesAreCached()) {
            Passport::routes();
        }*/

        Passport::tokensExpireIn(now()->addDays(15));
        Passport::refreshTokensExpireIn(now()->addDays(30));
        Passport::personalAccessTokensExpireIn(now()->addMonths(24));


        Paginator::useBootstrapFive();
        //Paginator::useBootstrapFour();
        Relation::morphMap([
            'Enquiry'  => Enquiry::class,
            'User'  => User::class,
            'Category' => Category::class,
            'Subcategory' => Subcategory::class,
            'Product' => Product::class,
        ]);
    }
}
