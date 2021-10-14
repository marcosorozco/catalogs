<?php

namespace Marcosorozco\Catalogs\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Marcosorozco\Catalogs\Http\Middleware\CatalogCodeValid;
use Marcosorozco\Catalogs\Sources\Catalogs\CatalogRepositoryInterface;
use Marcosorozco\Catalogs\Sources\Catalogs\CatalogValidator;

class CatalogServiceProvider extends ServiceProvider
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
    public function boot(Router $router)
    {
        Schema::defaultStringLength(191);
        $this->loadConfig($router);
    }

    private function loadConfig(Router $router) : void
    {
        $this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');
        $router->middlewareGroup('catalog-code-valid', [CatalogCodeValid::class]);
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