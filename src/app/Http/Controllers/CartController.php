<?php

namespace SeanDowney\BackpackStoreCrud\app\Http\Controllers;

use App\Http\Controllers\Controller;
use SeanDowney\BackpackStoreCrud\app\Cart\Cart;


class CartController extends Controller
{
    protected $cart;

    public function __construct(Cart $cart)
    {
        $this->cart = $cart;
    }

    public function index()
    {
        $viewData['title'] = 'Basket';

        /**
         * @TODO Check that the quantity selected is still available
         */

        return view('seandowney::frontend.cart', $viewData);
    }

    public function cart()
    {
        return $this->cart->summary();
    }


    public function destroy()
    {
        $this->cart->clear();

        return $this->cart->summary();
    }
}
