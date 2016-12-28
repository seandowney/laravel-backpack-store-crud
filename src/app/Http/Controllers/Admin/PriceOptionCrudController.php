<?php

namespace SeanDowney\BackpackStoreCrud\app\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
// VALIDATION: change the requests to match your own file names if you need form validation
use SeanDowney\BackpackStoreCrud\app\Http\Requests\PriceOptionRequest as StoreRequest;
use SeanDowney\BackpackStoreCrud\app\Http\Requests\PriceOptionRequest as UpdateRequest;

class PriceOptionCrudController extends CrudController
{
    public function __construct()
    {
        parent::__construct();

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel("SeanDowney\BackpackStoreCrud\app\Models\PriceOption");
        $this->crud->setRoute(config('backpack.base.route_prefix', 'admin').'/store/price_option');
        $this->crud->setEntityNameStrings('Price Option', 'Price Options');

        /*
        |--------------------------------------------------------------------------
        | COLUMNS AND FIELDS
        |--------------------------------------------------------------------------
        */

        // ------ CRUD COLUMNS
        $this->crud->addColumn([
                                'name' => 'title',
                                'label' => 'Title',
                            ]);
        $this->crud->addColumn([
                                'name' => 'code',
                                'label' => 'Code',
                            ]);
        $this->crud->addColumn([
                                'name' => 'price',
                                'label' => 'Price',
                            ]);
        $this->crud->addColumn([
                                'name' => 'status',
                                'label' => 'Status',
                            ]);

        // ------ CRUD FIELDS
        $this->crud->addField([    // TEXT
                                'name' => 'title',
                                'label' => 'Title',
                                'type' => 'text',
                                'placeholder' => 'Your title here',
                            ]);
        $this->crud->addField([
                                'name' => 'code',
                                'label' => 'Code',
                                'type' => 'text',
                                'hint' => '',
                                // 'disabled' => 'disabled'
                            ]);

        $this->crud->addField([    // Number
                                'name' => 'price',
                                'label' => 'Price',
                                'type' => 'number',
                                'attributes' => [
                                    'step' => '0.01',
                                    'min' => 0,
                                ],
                                'prefix' => "€",
                            ]);
        $this->crud->addField([    // ENUM
                                'name' => 'status',
                                'label' => 'Status',
                                'type' => 'enum',
                            ]);

        $this->crud->enableAjaxTable();
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
