<?php

namespace SeanDowney\BackpackStoreCrud\app\Http\Controllers;

use SeanDowney\BackpackStoreCrud\app\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use SeanDowney\BackpackStoreCrud\app\Models\Order;
use Illuminate\Support\Facades\Session;
use Stripe\Charge;
use Stripe\Stripe;
use Stripe\Customer;
use Illuminate\Support\Str;
use SeanDowney\BackpackStoreCrud\app\Events\OrderReceived;
use SeanDowney\BackpackStoreCrud\app\Cart\Cart;


class PurchaseController extends Controller
{
    protected $cart;

    public function __construct(Cart $cart)
    {
        $this->cart = $cart;
    }

    public function index()
    {
        $orderSummary = $this->cart->summary();

        /**
         * @TODO Check that the quantity selected is still available
         */

        $viewData['title'] = '';
        $viewData['countries'] = config('seandowney.storecrud.countries');

        $viewData['currency'] = config('seandowney.storecrud.currency.symbol');
        $viewData['standardDelivery'] = 0;
        $viewData['subTotal'] = $orderSummary['total'];
        $viewData['total'] = $orderSummary['total'];

        return view('seandowney::frontend.purchase_form', $viewData);
    }


    public function countryDelivery(Request $request)
    {
        request()->validate([
            'country' => 'required|max:2',
        ]);

        $country = request()->get('country');

        $deliveryDetails = [
            'message' => 'Sorry no delivery available to this country',
        ];

        $deliveryPrice = $this->cart->deliveryCostForCountry($country);

        if (!is_null($deliveryPrice)) {
            $deliveryDetails = [
                'price' => $deliveryPrice,
            ];
        }

        // check if there is a specific delivery option for this
        return response()->json($deliveryDetails);
    }

    /**
     * Process the purchase
     */
    public function pay()
    {
         request()->validate([
            'name' => 'required|min:5',
            'email' => 'required|email',
            'phone' => [
                'required',
                'regex:/(00|\+)[0-9]{9,15}/',
            ],
            'address1' => 'required|min:5',
            'address_city' => 'required|min:3',
            'address_state' => 'required|min:2',
            'country' => 'required|min:2|max:2',
            'terms_conditions' => 'accepted',
            'stripeToken' => 'required',
        ]);

        $orderSummary = $this->cart->summary();

        /**
         * @TODO Check that the quantity selected is still available
         */

        $country = request()->get('country');

        $deliveryPrice = $this->cart->deliveryCostForCountry($country);
        $deliveryPrice = is_null($deliveryPrice) ? 0 : $deliveryPrice;

        if (empty(request()->get('stripeToken'))) {
            session()->flash('error', 'Some error while making the payment. Please try again');
            return back()->withInput();
        }

        // Set your secret key: remember to change this to your live secret key in production
        // See your keys here: https://dashboard.stripe.com/account/apikeys
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));


        /**
         * @TODO Tidy up the Stripe payment part
         */
        try {
            /** Add customer to stripe, Stripe customer */
            Log::debug('Create Stripe Customer');
            $customer = Customer::create([
                'name'     => request('name'),
                'email'     => request('email'),
                'source'    => request('stripeToken')
            ]);
        } catch (\Exception $e) {
            $apiError = $e->getMessage();
        }

        $orderNum = Order::generateToken();
        $totalPrice = ($orderSummary['total'] + $deliveryPrice) * 100;

        if (empty($apiError) && $customer) {
            /** Charge a credit or a debit card */
            try {
                /** Stripe charge class */
                Log::debug('Create Stripe Charge');
                $charge = Charge::create(array(
                    'customer'      => $customer->id,
                    'amount'        => $totalPrice,
                    'currency'      => config('seandowney.storecrud.currency.code', 'EUR'),
                    'description'   => '',
                    'metadata'      => [
                        'order_num'  => $orderNum,
                    ]
                ));
            } catch (\Exception $e) {
                $apiError = $e->getMessage();
            }

            if (empty($apiError) && $charge) {
                Log::debug('Charge Created');

                // Retrieve charge details
                $paymentDetails = $charge->jsonSerialize();
                if ($paymentDetails['amount_refunded'] == 0 && empty($paymentDetails['failure_code']) && $paymentDetails['paid'] == 1 && $paymentDetails['captured'] == 1) {
                    Log::debug('Create Order');
                    $paymentDetails['customerId'] = $customer->id;
                    $paymentDetails['chargeId']   = $charge->id;

                    // Make the payment and merge the response with the request data, if successful.
                    $data = request()->only([
                        'name', 'email', 'phone', 'address1', 'address2', 'address_city', 'address_state', 'country', 'postcode',
                    ]);
                    $data['orderNum'] = $orderNum;
                    $data['delivery'] = $deliveryPrice;

                    $order = $this->cart->convertToOrder($data, $paymentDetails);

                    /**
                     * @TODO Products remaining
                     */
                    // if ($product->remaining) {
                    //     $product->remaining = $product->remaining - 1;
                    //     $product->save();
                    // }

                    // Charge::update($charge->id )

                    // clear the cart
                    $this->cart->clear();

                    Log::debug('Move to Thank You page');
                    $viewData = [];
                    $viewData['order_id'] = $order->id;
                    $viewData['order_num'] = $order->order_num;
                    $viewData['amount'] = $totalPrice;
                    $viewData['stripe_charge'] = $charge;
                    $viewData['receipt_url'] = $paymentDetails['receipt_url'];
                    return redirect('/'.config('seandowney.storecrud.route_prefix', 'store').'/thankyou')->with('order_id', $order->id);
                } else {
                    session()->flash('error', 'Transaction failed');
                    return back()->withInput();
                }
            } else {
                session()->flash('error', 'Error in capturing amount: ' . $apiError);
                return back()->withInput();
            }
        } else {
            session()->flash('error', 'Invalid card details: ' . $apiError);
            return back()->withInput();
        }
    }

    public function thankyou()
    {
        $order = Order::find(session('order_id'));
        return view('seandowney::frontend.thankyou', ['order' => $order]);
    }
}
