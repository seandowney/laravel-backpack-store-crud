# SeanDowney\BackpackStoreCrud

[![Latest Version on Packagist][ico-version]](link-packagist)
[![Software License][ico-license]](LICENSE.md)
[![Total Downloads][ico-downloads]][link-downloads]

An admin interface to easily add/edit/remove Store Products and Categories, using [Laravel Backpack](laravelbackpack.com).

## Install

1) In your terminal:

``` bash
$ composer require seandowney/backpackstorecrud
```

2) Add the service provider to your config/app.php file:
```php
SeanDowney\BackpackStoreCrud\StoreCrudServiceProvider::class,
```

3) Publish the config file & run the migrations
```bash
$ php artisan vendor:publish --provider="SeanDowney\BackpackStoreCrud\StoreCrudServiceProvider" #publish config, view  and migration files
$ php artisan migrate #create the store tables
```

4) [Optional] Add a menu item for it in resources/views/vendor/backpack/base/inc/sidebar.blade.php or menu.blade.php:

```html
<li class="treeview">
  <a href="#"><i class="fa fa-group"></i> <span>Store</span> <i class="fa fa-angle-left pull-right"></i></a>
  <ul class="treeview-menu">
      <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/'.config('seandowney.storecrud.route_prefix', 'store').'/product') }}"><i class="fa fa-newspaper-o"></i> <span>Products</span></a></li>
      <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/'.config('seandowney.storecrud.route_prefix', 'store').'/category') }}"><i class="fa fa-newspaper-o"></i> <span>Categories</span></a></li>
      <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/'.config('seandowney.storecrud.route_prefix', 'store').'/price_option') }}"><i class="fa fa-list"></i> <span>Price Options</span></a></li>
      <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/'.config('seandowney.storecrud.route_prefix', 'store').'/price_group') }}"><i class="fa fa-tag"></i> <span>Price Groups</span></a></li>
      <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/'.config('seandowney.storecrud.route_prefix', 'store').'/delivery_option') }}"><i class="fa fa-list"></i> <span>Delivery Options</span></a></li>
      <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/'.config('seandowney.storecrud.route_prefix', 'store').'/delivery_group') }}"><i class="fa fa-tag"></i> <span>Delivery Groups</span></a></li>
      <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/'.config('seandowney.storecrud.route_prefix', 'store').'/order') }}"><i class="fa fa-tag"></i> <span>Orders</span></a></li>
  </ul>
</li>
```

5) [Optional] Add a basic Store frontend using the base controllers.

* Add the Stripe pakage to the project
* If you want to use the Vue components, add the components to the `resources/assets/js/app.js` file
    * `Vue.component('review-cart', require('./components/ReviewCart.vue'));`
    * `Vue.component('header-cart', require('./components/HeaderCart.vue'));`
    * `Vue.component('product', require('./components/Product.vue'));`

* Add the following routes to your `routes/web.php` file:

```php
Route::group(['prefix' => config('seandowney.storecrud.route_prefix', 'store')], function () {
    Route::get('/', ['uses' => '\SeanDowney\BackpackStoreCrud\app\Http\Controllers\StoreController@index']);

    Route::get('category/{category}/{subs?}', ['uses' => '\SeanDowney\BackpackStoreCrud\app\Http\Controllers\StoreController@category'])
        ->where(['category' => '^((?!admin).)*$', 'subs' => '.*']);
    Route::get('product/{product}/{subs?}', ['uses' => '\SeanDowney\BackpackStoreCrud\app\Http\Controllers\ProductController@index'])
        ->where(['product' => '^((?!admin).)*$', 'subs' => '.*']);

    Route::get('purchase/{item}/{code}', ['uses' => '\SeanDowney\BackpackStoreCrud\app\Http\Controllers\PurchaseController@show'])
        ->where(['item' => '^((?!admin).)*$', 'code' => '.*']);
    Route::post('purchase/{item}/{code}', ['uses' => '\SeanDowney\BackpackStoreCrud\app\Http\Controllers\PurchaseController@pay'])
        ->where(['item' => '^((?!admin).)*$', 'code' => '.*']);
});
```

* Add the following routes to your `routes/api.php` file :

```php
Route::group(['prefix' => config('seandowney.storecrud.route_prefix', 'store'), 'middleware' => $middleware], function () {
    Route::post('country', ['uses' => '\SeanDowney\BackpackStoreCrud\app\Http\Controllers\PurchaseController@countryDelivery']);
    Route::get('cart', ['uses' => '\SeanDowney\BackpackStoreCrud\app\Http\Controllers\CartController@cart']);
    Route::get('cart/count', '\SeanDowney\BackpackStoreCrud\app\Http\Controllers\PurchaseController@count');
    Route::delete('cart', '\SeanDowney\BackpackStoreCrud\app\Http\Controllers\CartController@destroy');

    Route::apiResource('cart/items', '\SeanDowney\BackpackStoreCrud\app\Http\Controllers\CartItemController', ['only' => ['store', 'update', 'destroy']]);
});
```


## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.


## Testing

``` bash
// TODO
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email sean@considerweb.com instead of using the issue tracker.

## Credits

- Seán Downey - Lead Developer
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/seandowney/backpackstorecrud.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/seandowney/backpackstorecrud.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/seandowney/backpackstorecrud
[link-downloads]: https://packagist.org/packages/seandowney/backpackstorecrud
[link-contributors]: ../../contributors
