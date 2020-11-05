<?php

namespace SeanDowney\BackpackStoreCrud\app\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use SeanDowney\BackpackStoreCrud\app\Events\OrderStatusUpdated;
// VALIDATION: change the requests to match your own file names if you need form validation
use SeanDowney\BackpackStoreCrud\app\Http\Requests\OrderRequest as StoreRequest;
use SeanDowney\BackpackStoreCrud\app\Http\Requests\OrderRequest as UpdateRequest;

class OrderCrudController extends CrudController
{
    public function __construct()
    {
        parent::__construct();

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel("SeanDowney\BackpackStoreCrud\app\Models\Order");
        $this->crud->setRoute(config('backpack.base.route_prefix', 'admin').'/'.config('seandowney.storecrud.route_prefix', 'store').'/order');
        $this->crud->setEntityNameStrings('Order', 'Orders');

        $this->crud->denyAccess('create');

        // if (!request()->has('order')) {
        //     $this->crud->orderBy('updated_at'. 'desc');
        // }

        /*
        |--------------------------------------------------------------------------
        | COLUMNS AND FIELDS
        |--------------------------------------------------------------------------
        */

        // $this->crud->addFilter([ // daterange filter
        //     'type' => 'date_range',
        //     'name' => 'from_to',
        //     'label'=> 'Date range'
        //  ],
        //  false,
        //  function($value) { // if the filter is active, apply these constraints
        //     $dates = json_decode($value);
        //     $this->crud->addClause('where', 'created_at', '>=', $dates->from);
        //     $this->crud->addClause('where', 'created_at', '<=', $dates->to . ' 23:59:59');
        //  });

        // ------ CRUD COLUMNS
        $this->crud->addColumn([
            'name' => 'id',
            'label' => 'ID',
        ]);
        $this->crud->addColumn([
            'name' => 'name',
            'label' => 'Customer Name',
        ]);
        $this->crud->addColumn([
            'name' => 'total',
            'label' => 'Total',
        ]);
        $this->crud->addColumn([
            'name' => 'status',
            'label' => 'Status',
        ]);
        $this->crud->addColumn([
            'name' => 'updated_at',
            'label' => 'Updated',
        ]);

        // ------ CRUD FIELDS
        $this->crud->addField([
            'name' => 'created_at',
            'label' => 'Order Placed',
            'type' => 'datetime',
            'attributes' => [
                'readonly' => 'readonly',
                'disabled' => 'disabled',
            ],
            'tab' => 'Order Details'
        ]);
        $this->crud->addField([
            'name' => 'updated_at',
            'label' => 'Updated',
            'type' => 'datetime',
            'attributes' => [
                'readonly' => 'readonly',
                'disabled' => 'disabled',
            ],
            'tab' => 'Order Details'
        ]);
        $this->crud->addField([
            'name' => 'separator',
            'type' => 'custom_html',
            'value' => '<hr>',
            'tab' => 'Order Details'
        ]);
        $this->crud->addField([    // TEXT
            'name' => 'name',
            'label' => 'Customer Name',
            'type' => 'text',
            'placeholder' => 'Customer Name',
            'tab' => 'Order Details',
            'attributes' => [
                'readonly' => 'readonly',
                'disabled' => 'disabled',
            ],
        ]);
        $this->crud->addField([
            'name' => 'email',
            'label' => 'Customer Email',
            'type' => 'text',
            'tab' => 'Order Details',
            'attributes' => [
                'readonly' => 'readonly',
                'disabled' => 'disabled',
            ],
        ]);
        $this->crud->addField([
            'name' => 'phone',
            'label' => 'Customer Phone',
            'type' => 'text',
            'tab' => 'Order Details',
            'attributes' => [
                'readonly' => 'readonly',
                'disabled' => 'disabled',
            ],
        ]);
        $this->crud->addField([
            'name' => 'address',
            'label' => 'Address',
            'type' => 'text',
            'tab' => 'Order Details',
            'attributes' => [
                'readonly' => 'readonly',
                'disabled' => 'disabled',
            ],
        ]);
        $this->crud->addField([
            'name' => 'city',
            'label' => 'City',
            'type' => 'text',
            'tab' => 'Order Details',
            'attributes' => [
                'readonly' => 'readonly',
                'disabled' => 'disabled',
            ],
        ]);
        $this->crud->addField([
            'name' => 'state',
            'label' => 'State',
            'type' => 'text',
            'tab' => 'Order Details',
            'attributes' => [
                'readonly' => 'readonly',
                'disabled' => 'disabled',
            ],
        ]);
        $this->crud->addField([
            'name' => 'postcode',
            'label' => 'Postcode',
            'type' => 'text',
            'tab' => 'Order Details',
            'attributes' => [
                'readonly' => 'readonly',
                'disabled' => 'disabled',
            ],
        ]);
        $this->crud->addField([
            'name' => 'country',
            'label' => 'Country',
            'type' => 'text',
            'tab' => 'Order Details',
            'attributes' => [
                'readonly' => 'readonly',
                'disabled' => 'disabled',
            ],
        ]);

        $this->crud->addField([
            'name' => 'separator2',
            'type' => 'custom_html',
            'value' => '<hr>',
            'tab' => 'Order Details'
        ]);

        $this->crud->addField([
            'label' => 'Order Items',
            'type' => 'order_items',
            'name' => 'items',
            // 'entity' => 'items', // the method that defines the relationship in your Model
            'attribute' => 'title',
            'model' => "SeanDowney\BackpackStoreCrud\app\Models\OrderItem", // foreign key model
            'pivot' => false, // on create&update, do you need to add/delete pivot table entries?
            // 'options' => $this->crud->getCurrentEntry()->items,
            'columns' => ['sku', 'title', 'quantity', 'total'],
            'tab' => 'Order Details'
        ]);
        $this->crud->addField([
            'name' => 'sub_total',
            'label' => 'Sub Total',
            'type' => 'number',
            'attributes' => [
                'readonly' => 'readonly',
            ],
            'tab' => 'Order Details'
        ]);
        $this->crud->addField([
            'name' => 'delivery_cost',
            'label' => 'Delivery Cost',
            'type' => 'number',
            'attributes' => [
                'readonly' => 'readonly',
            ],
            'tab' => 'Order Details'
        ]);
        $this->crud->addField([
            'name' => 'total',
            'label' => 'Total',
            'type' => 'number',
            'attributes' => [
                'readonly' => 'readonly',
            ],
            'tab' => 'Order Details'
        ]);
        $this->crud->addField([
            'name' => 'separator3',
            'type' => 'custom_html',
            'value' => '<hr>',
            'tab' => 'Order Details'
        ]);

        $this->crud->addField([    // ENUM
            'name' => 'shipping_code',
            'label' => 'Tracking Code',
            'type' => 'text',
            'attributes' => [
                'placeholder' => 'From An Post',
            ],
            'tab' => 'Order Details'
        ]);
        $this->crud->addField([    // ENUM
            'name' => 'status',
            'label' => 'Status',
            'type' => 'number',
            'tab' => 'Order Details'
        ]);
        // $this->crud->addField([    // ENUM
        //     'name' => 'status',
        //     'label' => 'Status',
        //     'type' => 'select2',
        //     'entity' => 'orderStatus',
        //     'attribute' => 'title',
        //     'model' => "SeanDowney\BackpackStoreCrud\app\Models\OrderStatus",
        //     'tab' => 'Order Details'
        // ]);

        $this->crud->addField([
            'name' => 'customer_id',
            'label' => 'Stripe Customer',
            'type' => 'text',
            'attributes' => [
                'readonly' => 'readonly',
            ],
            'tab' => 'Stripe Details'
        ]);
        $this->crud->addField([
            'name' => 'transaction_id',
            'label' => 'Stripe Transaction',
            'type' => 'text',
            'attributes' => [
                'readonly' => 'readonly',
            ],
            'tab' => 'Stripe Details'
        ]);
        $this->crud->addField([
            'name' => 'payment_status',
            'label' => 'Stripe Payment',
            'type' => 'text',
            'attributes' => [
                'readonly' => 'readonly',
            ],
            'tab' => 'Stripe Details'
        ]);
        $this->crud->addField([
            'name' => 'receipt_url',
            'label' => 'Receipt Url',
            'type' => 'text',
            'attributes' => [
                'readonly' => 'readonly',
            ],
            'tab' => 'Stripe Details'
        ]);
    }

    public function store(StoreRequest $request)
    {
        return parent::storeCrud();
    }

    public function update(UpdateRequest $request)
    {
        $current = $this->crud->getCurrentEntry();

        $response = parent::updateCrud();

        $updated = $this->crud->getCurrentEntry();
        if ($updated->status !== $current->status) {
            event(new OrderStatusUpdated($updated));
        }

        return $response;
    }
}
