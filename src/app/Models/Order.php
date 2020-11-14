<?php

namespace SeanDowney\BackpackStoreCrud\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Backpack\CRUD\CrudTrait;

class Order extends Model
{
    use CrudTrait;

    protected $table = 'store_orders';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $guarded = ['id', ];
    protected $fillable = [
            'order_num', 'transaction_id', 'customer_id', 'name', 'email', 'phone',
            'payment_status', 'receipt_url', 'shipped_at', 'shipping_code',
            'address', 'city', 'state', 'postcode', 'country', 'status', 'total', 'delivery_cost', 'sub_total', 'tax'];
    // protected $hidden = [];
    protected $dates = ['shipped_at'];
    protected $casts = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    public static function generateToken()
    {
        return (string) Str::uuid();
    }

    public function isProcessing()
    {
        return $this->status == ORDER_PROCESSING;
    }

    public function isDispatched()
    {
        return $this->status == ORDER_DISPATCHED;
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function items()
    {
        return $this->hasMany('SeanDowney\BackpackStoreCrud\app\Models\OrderItem', 'order_id');
    }


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
