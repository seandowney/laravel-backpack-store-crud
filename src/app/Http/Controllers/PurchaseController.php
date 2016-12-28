<?php

namespace SeanDowney\BackpackStoreCrud\app\Http\Controllers;

use SeanDowney\BackpackStoreCrud\app\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function show($slug, $code)
    {
        $product = Product::findBySlug($slug);

        if (!$product) {
            abort(404, 'Please go back to our <a href="'.url('').'">homepage</a>.');
        }

        $option = $product->options()->where('code', $code)->first()->toArray();

        $this->data['title'] = $product->title;
        $this->data['product'] = $product->withFakes();
        $this->data['images'] = $product->images;
        $this->data['option'] = $option;

        return view('seandowney::store.purchase_form', $this->data);
    }

    public function pay(Request $request, $slug, $code)
    {
        $product = Product::findBySlug($slug);

        if (!$product) {
            abort(404, 'Please go back to our <a href="'.url('').'">homepage</a>.');
        }

        $option = $product->options()->where('code', $code)->first()->toArray();

        // Set your secret key: remember to change this to your live secret key in production
        // See your keys here: https://dashboard.stripe.com/account/apikeys
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        // Get the credit card details submitted by the form
        // $token = $_POST['stripeToken'];

        // Create a charge: this will charge the user's card
        try {
            $order_id = 'wsad';
          $charge = \Stripe\Charge::create([
                "amount" => $option['price'] * 100, // Amount in cents
                "currency" => "eur",
                "source" => $request->input('stripeToken'),
                "description" => $product->title.' '.$option['title'],
                "metadata" => [
                    "order_id" => $order_id,
                ],
            ]);

            // echo "<pre>".print_r($charge, true)."</pre>".PHP_EOL;
            $this->data = [];
            $this->data['title'] = $product->title;
            $this->data['product'] = $product;
            $this->data['order_id'] = $order_id;
            $this->data['amount'] = $option['price'];
            return view('seandowney::store.purchase_success', $this->data);
        } catch(\Stripe\Error\Card $e) {
          // The card has been declined
        }
    }
}
