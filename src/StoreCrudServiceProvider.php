<?php

namespace SeanDowney\BackpackStoreCrud;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use SeanDowney\BackpackStoreCrud\app\Providers\EventServiceProvider;

class StoreCrudServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // LOAD THE VIEWS
        // - first the published views (in case they have any changes)
        $this->loadViewsFrom(resource_path('views/vendor/seandowney/storecrud'), 'seandowney');
        // - then the stock views that come with the package, in case a published view might be missing
        $this->loadViewsFrom(realpath(__DIR__.'/resources/views'), 'seandowney');

        $this->mergeConfigFrom(
            __DIR__.'/config/seandowney/storecrud.php', 'seandowney.storecrud'
        );

        // publish views
        $this->publishes([__DIR__.'/resources/views' => resource_path('views/vendor/seandowney/storecrud')], 'views');

        // publish vue components
        $this->publishes([__DIR__.'/resources/assets/js' => resource_path('assets/js')], 'js');

        // publish migrations
        $this->publishes([__DIR__.'/database/migrations' => database_path('migrations')], 'migrations');

        // publish config file
        $this->publishes([__DIR__.'/config' => config_path()], 'config');
    }

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function setupRoutes(Router $router)
    {
        $router->group(['namespace' => 'SeanDowney\BackpackStoreCrud\app\Http\Controllers'], function ($router) {
            \Route::group(['prefix' => config('backpack.base.route_prefix', 'admin').'/'.config('seandowney.storecrud.route_prefix', 'store'), 'middleware' => ['web', 'admin'], 'namespace' => 'Admin'], function () {
                \Route::get('/', function () {
                    return redirect('category');
                });
                \CRUD::resource('category', 'CategoryCrudController');
                \CRUD::resource('product', 'ProductCrudController');
                \CRUD::resource('price_option', 'PriceOptionCrudController');
                \CRUD::resource('price_group', 'PriceGroupCrudController');
                \CRUD::resource('delivery_option', 'DeliveryOptionCrudController');
                \CRUD::resource('delivery_group', 'DeliveryGroupCrudController');
                \CRUD::resource('order', 'OrderCrudController');
            });
        });
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        // register its dependencies
        $this->app->register(\Cviebrock\EloquentSluggable\ServiceProvider::class);

        $this->setupRoutes($this->app->router);

        $this->app->register(EventServiceProvider::class);
    }
}
