<?php

namespace App\Providers;

use App\Repository\Interfaces\NewsRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use App\Repository\NewsRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(NewsRepositoryInterface::class, NewsRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
