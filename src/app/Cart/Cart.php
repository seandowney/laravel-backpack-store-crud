<?php

namespace SeanDowney\BackpackStoreCrud\app\Cart;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Collection;
use SeanDowney\BackpackStoreCrud\app\Events\OrderReceived;
use SeanDowney\BackpackStoreCrud\app\Models\Order;
use SeanDowney\BackpackStoreCrud\app\Models\Product;

class Cart
{
    /**
     * Retrieve all cart items from the store.
     *
     * @return array|null
     */
    public function get() {
        return unserialize(Session::get('shopkey')) ?: null;
    }

    /**
     * Persists the cart items in the store.
     *
     * @return void
     */
    public function persist($data) {
        Session::put('shopkey', serialize($data));

    }

    /**
     * Returns all items regardless of type.
     *
     * @return Collection
     */
    public function getAllItems(): Collection
    {
        return collect($this->get());
    }

    /**
     * Returns the regular cart items.
     *
     * @return Collection
     */
    public function items(): Collection
    {
        return $this->getAllItems();
    }

    /**
     * Returns the discount coupons added to the cart.
     *
     * @return Collection
     */
    public function discounts(): Collection
    {
        return $this->getAllItems()->filter(function ($item) {
            return $item->shoppable->isDiscount() === true;
        })->values();
    }

    /**
     * Returns only the relative discount coupons added to the cart.
     *
     * @return Collection
     */
    public function relativeDiscounts(): Collection
    {
        return $this->discounts()->filter(function ($discount) {
            return ! $discount->shoppable->is_fixed;
        });
    }

    /**
     * Returns the full cart summary.
     *
     * @return array
     */
    public function summary()
    {
        $subTotal = $this->subTotal();
        $taxTotal = $this->taxTotal();
        $total = $this->total();
        // $formatter = app(Formatter::class);

        return [
            'items' => $this->items(),
            // 'discounts' => $this->discounts(),
            'sub_total' => $subTotal,
            // 'sub_total_formatted' => $formatter->format($subTotal),
            'tax_total' => $taxTotal,
            // 'tax_total_formatted' => $formatter->format($taxTotal),
            'total' => $total,
            // 'total_formatted' => $formatter->format($total),
            'count' => $this->count(),
        ];
    }

    /**
     * Returns the sub total of the cart.
     *
     * @return float
     */
    public function subTotal()
    {
        return $this->total() - $this->taxTotal();
    }

    /**
     * Returns the total tax of the items in the cart.
     *
     * @return float
     */
    public function taxTotal()
    {
        $tax = config('shopr.tax');

        if (! $tax || $tax <= 0) {
            return 0;
        }

        return $this->total() * $tax / (100 + $tax);
    }

    /**
     * Returns the total amount of the items in the cart.
     *
     * @return float
     */
    public function total()
    {
        $total = 0;

        foreach ($this->getAllItems() as $item) {
            // This includes the sub items.
            $total += $item->total;
        }

        return $total;
    }

    /**
     * Returns the total amount of the items in the cart, discounts excluded.
     *
     * @return float
     */
    public function totalWithoutDiscounts()
    {
        $total = 0;

        foreach ($this->items() as $item) {
            // This includes the sub items.
            $total += $item->total();
        }

        return $total;
    }

    /**
     * Returns true if the cart is empty, false if not.
     *
     * @return bool
     */
    public function isEmpty()
    {
        return $this->count() === 0;
    }

    /**
     * Returns the total count of the items added to the cart.
     *
     * @return int
     */
    public function count()
    {
        return $this->items()->sum('num');
    }


    /**
     * Calculate the Delivery Cost for a country
     *
     * @param string $country
     * @return null|int
     */
    public function deliveryCostForCountry(string $country)
    {
        $orderSummary = $this->summary();

        $deliveryPrice = null;
        // loop through the cart items to work out the higher delivery cost
        foreach ($orderSummary['items'] as $item) {
            $deliveryGroup = $item->option->deliveryGroup;
            $deliveryOptions = $deliveryGroup->deliveryOptions;

            $countryOption = $deliveryOptions->firstWhere('country_code', $country);

            if (is_null($countryOption)) {
                // check if there is a continent price
                  $continent = config('seandowney.storecrud.continents')[$country];
                  $countryOption = $deliveryOptions->firstWhere('country_code', $continent);
              }

              if (is_null($countryOption)) {
                // check if there is a continent price
                  $countryOption = $deliveryOptions->firstWhere('country_code', 'OT');
              }

              if (!is_null($countryOption)) {
                  $delivery = $countryOption->only(['title', 'price']);
                  if (is_null($deliveryPrice) or $deliveryPrice <= $delivery['price']) {
                    $deliveryPrice = $delivery['price'];
                }
            }
        }

        return $deliveryPrice;
    }

    /**
     * Calculates the total value of the coupon and adds it to the cart.
     *
     * @param  Shoppable $coupon
     * @return CartItem|false
     */
    public function addDiscount(Shoppable $coupon)
    {
        if (! $coupon->isDiscount()) {
            return false;
        }

        $item = $this->addItem(get_class($coupon), $coupon->id, 1, [], [], $coupon->getPrice());

        $coupon->increment('uses');

        event('shopr.cart.discounts.added', $item);

        return $item;
    }

    /**
     * Iterates all the current items in the cart and returns true if one of them is
     * a discount coupon matching the given code. If no code is provided, it will return false on any
     * discount coupon.
     *
     * @param  string  $code
     * @return bool
     */
    public function hasDiscount($code = null): bool
    {
        foreach ($this->discounts() as $item) {
            if (! $code) {
                return true;
            } elseif ($item->shoppable->getTitle() === $code) {
                return true;
            }
        }

        return false;
    }

    /**
     * Converts the current cart to an order and clears the cart.
     *
     * @param  string $gateway
     * @param  array  $data
     * @return \SeanDowney\BackpackStoreCrud\app\Models\Order|false
     */
    public function convertToOrder($data, $paymentDetails)
    {
        if ($this->isEmpty()) {
            return false;
        }

        $orderSummary = $this->summary();

        $order = Order::create([
            'order_num'       => $data['orderNum'],
            'name'            => optional($data)['name'],
            'email'           => optional($data)['email'],
            'phone'           => optional($data)['phone'],
            'address'         => optional($data)['address1'].', '.optional($data)['address2'],
            'city'            => optional($data)['address_city'],
            'state'           => optional($data)['address_state'],
            'postcode'        => optional($data)['postcode'],
            'country'         => optional($data)['country'],
            'transaction_id'  => $paymentDetails['chargeId'],
            'customer_id'     => $paymentDetails['customerId'],
            'payment_status'  => $paymentDetails['status'],
            'receipt_url'     => $paymentDetails['receipt_url'],
            'sub_total'       => $orderSummary['total'],
            'delivery_cost'   => optional($data)['delivery'],
            'total'           => $orderSummary['total'] + $data['delivery'],
        ]);

        foreach ($this->getAllItems() as $item) {
            $order->items()->create([
                'sku'         => $item->id,
                'title'       => $item->product->title.' '.$item->option->title,
                'product_id'  => $item->product->id,
                'option_id'   => $item->option->id,
                'quantity'    => $item->num,
                'price'       => $item->price,
                'total'       => $item->total,
                // 'options'     => '',
            ]);
        }

        event(new OrderReceived($order));

        return $order;
    }

    /**
     * Adds an item to the cart.
     *
     * @param string $skuCode
     * @param int    $quantity
     * @return object
     */
    public function addItem($skuCode, $quantity)
    {
        $quantity = (is_numeric($quantity) && $quantity > 0) ? $quantity : 1;

        $skuSplit = explode('-', $skuCode);
        $product = Product::findByCode($skuSplit[0]);

        if ($product) {
            $option = $product->options()->where('code', $skuSplit[1])->first();
        }

        $productNum = 1;
        $items = $this->getAllItems();
        $item = [];
        $item['id'] = $skuCode;
        $item['product'] = (object) $product->only(['id', 'code', 'title']);
        $item['option'] = $option;
        $item['num'] = $quantity;
        $item['price'] = $option->price;
        $item['total'] = $option->price * $quantity;
        $item = (object) $item;

        // // Find already added items that are identical to current selection.
        $identicals = $items->filter(function ($row) use ($item) {
            return
                $row->id === $item->id;
        });

        // If an identical item already exists in the cart, add to it's quantity.
        // Otherwise, push it.
        if ($identicals->count() > 0) {
            $items->where('id', $identicals->first()->id)->first()->num += 1;
            $item->num = $items->where('id', $identicals->first()->id)->first()->num;
            $items->where('id', $identicals->first()->id)->first()->total = $item->option->price * $item->num;
            $item->total = $item->option->price * $item->num;
        } else {
            $items->push($item);
        }

        $this->persist($items);

        return $item;
    }

    /**
     * Updates a single item in the cart.
     *
     * @param  string $id
     * @param  array $data
     * @return Happypixels\Shopr\Cart\CartItem
     */
    public function updateItem($id, $data)
    {
        $items = $this->getAllItems();
        $item = null;

        foreach ($items as $index => $item) {
            if ($item->id !== $id || empty($data['num'])) {
                continue;
            }

            $items[$index]->quantity = intval($data['num']);

            if (! empty($items[$index]->subItems)) {
                foreach ($items[$index]->subItems as $i => $subItem) {
                    $items[$index]->subItems[$i]->num = intval($data['num']);
                    $items[$index]->subItems[$i]->total = $items[$index]->subItems[$i]->total();
                }
            }

            $items[$index]->total = $items[$index]->total();
            $item = $items[$index];
        }

        $this->persist($items);

        // Refresh relative discount values.
        foreach ($items as $index => $item) {
            if (! $item->shoppable->isDiscount()) {
                continue;
            }

            $items[$index]->refreshDiscountValue();
        }

        $this->persist($items);

        event('shopr.cart.items.updated', $item);

        return $item;
    }

    /**
     * Removes a single item from the cart.
     *
     * @param  string $id
     * @return Happypixels\Shopr\Cart\CartItem
     */
    public function removeItem($id)
    {
        $items = $this->getAllItems();
        $removedItem = null;

        foreach ($items as $index => $item) {
            if ($item->id === $id) {
                $removedItem = $items[$index];

                $items[$index]->num--;
                $items[$index]->total = $items[$index]->num * $items[$index]->option->price;
                if ($items[$index]->num == 0) {
                    unset($items[$index]);
                }
            }
        }

        $this->persist($items);

        // If the cart is cleared of shoppable items, also remove any discounts.
        if ($this->items()->count() === 0) {
            $this->clear();
        }

        // if ($removedItem) {
        //     event('shopr.cart.items.deleted', $removedItem);
        // }

        return $removedItem;
    }

    /**
     * Clears the cart and fires appropriate event.
     *
     * @return void
     */
    public function clear()
    {
        $this->persist(collect([]));

        // event('shopr.cart.cleared');
    }
}
