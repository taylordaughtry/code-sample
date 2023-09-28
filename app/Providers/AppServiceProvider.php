<?php

namespace App\Providers;

use App\Repositories\GoogleCalendar;
use Illuminate\Support\ServiceProvider;
use App\Interfaces\EventRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(EventRepositoryInterface::class, GoogleCalendar::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
