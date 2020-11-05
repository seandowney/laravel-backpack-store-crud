<?php

namespace SeanDowney\BackpackStoreCrud\app\Http\Controllers;

use SeanDowney\BackpackStoreCrud\app\Cart\Cart;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use SeanDowney\BackpackStoreCrud\app\Models\Product;

class CartItemController extends Controller
{
    protected $cart;

    public function __construct(Cart $cart)
    {
        $this->cart = $cart;
    }

    public function store(Request $request)
    {
        request()->validate([
            'sku' => 'required',
            'quantity' => 'required|integer',
        ]);

        $sku = request()->get('sku');

        $item = $this->cart->addItem($sku, request()->get('quantity'));

        return $this->cart->summary();
    }


    public function destroy(Request $request, $skuCode)
    {
        $this->cart->removeItem($skuCode);

        return $this->cart->summary();

        $product_sku = unserialize(Session::get('shopkey')) ?: null;

        if (isset($product_sku['sku'][$skuCode]) and $product_sku['sku'][$skuCode] > 1) {
            $product_sku['sku'][$skuCode]--;
        } else {
            unset($product_sku['sku'][$skuCode]);
        }

        Session::put('shopkey', serialize($product_sku));

        return redirect(config('seandowney.storecrud.route_prefix', 'store').'/purchase');
    }
}
