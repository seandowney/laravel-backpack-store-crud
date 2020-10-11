<?php

namespace SeanDowney\BackpackStoreCrud\app\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
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
        $this->crud->setRoute(config('backpack.base.route_prefix', 'admin').'/store/order');
        $this->crud->setEntityNameStrings('Order', 'Orders');

        $this->crud->denyAccess('create');

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
                                'label' => 'Name',
                            ]);
        $this->crud->addColumn([
                                'name' => 'order_details',
                                'label' => 'Order Details',
                            ]);
        $this->crud->addColumn([
                                'name' => 'amount',
                                'label' => 'Amount',
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
            ],
            'tab' => 'Order Details'
        ]);
        $this->crud->addField([
            'name' => 'updated_at',
            'label' => 'Updated',
            'type' => 'datetime',
            'attributes' => [
                'readonly' => 'readonly',
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
            'tab' => 'Order Details'
        ]);
        $this->crud->addField([
            'name' => 'email',
            'label' => 'Customer Email',
            'type' => 'text',
            'tab' => 'Order Details'
        ]);
        $this->crud->addField([
            'name' => 'order_details',
            'label' => 'Order Details',
            'type' => 'text',
            'attributes' => [
                'readonly' => 'readonly',
            ],
            'tab' => 'Order Details'
        ]);
        $this->crud->addField([
            'name' => 'amount',
            'label' => 'Amount',
            'type' => 'number',
            'attributes' => [
                'readonly' => 'readonly',
            ],
            'tab' => 'Order Details'
        ]);
        $this->crud->addField([
            'name' => 'separator',
            'type' => 'custom_html',
            'value' => '<hr>',
            'tab' => 'Order Details'
        ]);

        $this->crud->addField([    // WYSIWYG
            'name' => 'shipping_address',
            'label' => 'Shipping Address',
            'type' => 'textarea',
            'placeholder' => 'Shipping Address here',
            'tab' => 'Order Details',
            'attributes' => [
                'rows' => 6,
            ]
        ]);
        $this->crud->addField([    // WYSIWYG
            'name' => 'shipping_notes',
            'label' => 'Shipping Notes',
            'type' => 'textarea',
            'placeholder' => 'Shipping Notes here',
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
        return parent::updateCrud();
    }
}
