<?php

namespace App\Providers;

use App\Ahkas\Domain\User\UserModel;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserModel::class, function () {
            return auth()->user();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
            request()->server->set('HTTPS', 'on');
        }
    }
}
