<?php

namespace SeanDowney\BackpackStoreCrud\app\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class Order extends Model
{
    use CrudTrait;

    protected $table = 'store_orders';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $guarded = ['id', ];
    protected $fillable = [
            'order_num', 'transaction_id', 'customer_id', 'name', 'email', 'order_details',
            'payment_status', 'receipt_url',
            'shipping_address', 'shipping_notes', 'status', 'amount', 'net_amount'];
    // protected $hidden = [];
    protected $dates = ['shipped_at'];
    protected $casts = [];

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
