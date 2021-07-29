<?php

namespace App\Providers;

use App\Models\Transaction;
use App\Observers\TransactionObserver;
use Illuminate\Config\Repository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('failure-responses', function ($app) {
            return new Repository(
                $app->make('files')
                    ->getRequire(resource_path('/responses/failure-responses.php'))
            );
        });

        $this->app->singleton('success-responses', function ($app) {
            return new Repository(
                $app->make('files')
                    ->getRequire(resource_path('/responses/success-responses.php'))
            );
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Transaction::observe(new TransactionObserver());
    }
}
