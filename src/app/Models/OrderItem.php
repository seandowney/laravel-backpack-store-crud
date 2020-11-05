<?php

namespace SeanDowney\BackpackStoreCrud\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Backpack\CRUD\CrudTrait;

class OrderItem extends Model
{
    use CrudTrait;

    protected $table = 'store_order_items';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $guarded = ['id', ];
    protected $fillable = [
        'order_id',
        'sku',
        'product_id',
        'option_id',
        'quantity',
        'title',
        'price',
        'total',
        'options',
    ];

    protected $casts = [
        'options' => 'array',
    ];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */


    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */


    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
