<?php

namespace App\Providers;

use App\Contracts\V1\Account\{ManagesAccount, RecoversAccount};
use App\Services\V1\Account\{AccountManager, AccountRetriever};
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(RecoversAccount::class, AccountRetriever::class);
        $this->app->bind(ManagesAccount::class, AccountManager::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
