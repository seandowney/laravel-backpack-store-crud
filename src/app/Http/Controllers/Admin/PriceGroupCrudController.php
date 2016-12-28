<?php

namespace SeanDowney\BackpackStoreCrud\app\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
// VALIDATION: change the requests to match your own file names if you need form validation
use SeanDowney\BackpackStoreCrud\app\Http\Requests\PriceGroupRequest as StoreRequest;
use SeanDowney\BackpackStoreCrud\app\Http\Requests\PriceGroupRequest as UpdateRequest;

class PriceGroupCrudController extends CrudController
{
    public function __construct()
    {
        parent::__construct();

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel("SeanDowney\BackpackStoreCrud\app\Models\PriceGroup");
        $this->crud->setRoute(config('backpack.base.route_prefix', 'admin').'/store/price_group');
        $this->crud->setEntityNameStrings('Price Group', 'Price Groups');

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
        $this->crud->addField([       // Select2Multiple = n-n relationship (with pivot table)
                                'label' => 'Price Options',
                                'type' => 'select2_multiple',
                                'name' => 'priceOptions', // the method that defines the relationship in your Model
                                'entity' => 'priceOptions', // the method that defines the relationship in your Model
                                'attribute' => 'title', // foreign key attribute that is shown to user
                                'model' => "SeanDowney\BackpackStoreCrud\app\Models\PriceOption", // foreign key model
                                'pivot' => true, // on create&update, do you need to add/delete pivot table entries?
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
