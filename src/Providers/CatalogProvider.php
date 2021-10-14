<?php

namespace Marcosorozco\Catalogs\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Marcosorozco\Catalogs\Sources\Catalogs\CatalogRepositoryInterface;
use Marcosorozco\Catalogs\Sources\Catalogs\CatalogValidator;

class CatalogProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        # Catalogs
        $this->app->bind(CatalogRepositoryInterface::class, CatalogValidator::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        $this->loadConfig();
    }

    private function loadConfig() : void
    {
        $this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');
        $this->publishes(
            [
                __DIR__ . '/../../config/catalog.php' => config_path('catalog.php'),
                __DIR__ . '/../../database/migrations' => base_path('database/migrations'),
                __DIR__ . '/../../resources/views' => resource_path('views'),
            ],
            'catalog'
        );
    }
}