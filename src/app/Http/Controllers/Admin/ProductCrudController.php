<?php

namespace SeanDowney\BackpackStoreCrud\app\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
// VALIDATION: change the requests to match your own file names if you need form validation
use SeanDowney\BackpackStoreCrud\app\Http\Requests\ProductRequest as StoreRequest;
use SeanDowney\BackpackStoreCrud\app\Http\Requests\ProductRequest as UpdateRequest;

class ProductCrudController extends CrudController
{
    public function __construct()
    {
        parent::__construct();

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel("SeanDowney\BackpackStoreCrud\app\Models\Product");
        $this->crud->setRoute(config('backpack.base.route_prefix', 'admin').'/'.config('seandowney.storecrud.route_prefix', 'store').'/product');
        $this->crud->setEntityNameStrings('Product', 'Products');

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
            'name' => 'remaining_num',
            'label' => 'Remaining',
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
            'name' => 'slug',
            'label' => 'Slug (URL)',
            'type' => 'text',
            'hint' => 'Will be automatically generated from your title, if left empty.',
        ]);

        $this->crud->addField([
            'name' => 'code',
            'label' => 'SKU Prefix',
            'type' => 'text',
            'hint' => 'Prefix for the SKU Code',
        ]);
        $this->crud->addField([
            'name' => 'intro',
            'label' => 'Intro',
            'type' => 'text',
            'hint' => 'Used on the Category pages',
        ]);
        $this->crud->addField([    // WYSIWYG
            'name' => 'description',
            'label' => 'Description',
            'type' => 'ckeditor',
            'placeholder' => 'Your textarea text here',
        ]);
        $this->crud->addField([    // Product
            'name' => 'images',
            'label' => 'Images',
            'type' => 'upload_multiple',
            'upload' => true,
            'disk' => 'public',
        ]);
        $this->crud->addField([       // Select2Multiple = n-n relationship (with pivot table)
            'label' => 'Categories',
            'type' => 'select2_multiple',
            'name' => 'categories', // the method that defines the relationship in your Model
            'entity' => 'categories', // the method that defines the relationship in your Model
            'attribute' => 'title', // foreign key attribute that is shown to user
            'model' => "SeanDowney\BackpackStoreCrud\app\Models\Category", // foreign key model
            'pivot' => true, // on create&update, do you need to add/delete pivot table entries?
        ]);
        $this->crud->addField([    // SELECT
            'label' => 'Price Group',
            'type' => 'select2',
            'name' => 'price_group_id',
            'entity' => 'priceGroup',
            'attribute' => 'title',
            'model' => "SeanDowney\BackpackStoreCrud\app\Models\PriceGroup",
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
        $this->crud->addField([    // Number
            'name'  => 'price_from',
            'label' => 'Price From',
            'type'  => 'text',
            'hint'  => 'Used on the Cateory pages eg €45 to €75',
        ]);
        $this->crud->addField([    // Number
            'name' => 'total_num',
            'label' => 'Total Num',
            'type' => 'number',
        ]);
        $this->crud->addField([    // Number
            'name' => 'remaining_num',
            'label' => 'Remaining',
            'type' => 'number',
        ]);
        $this->crud->addField([    // CHECKBOX
            'name' => 'featured',
            'label' => 'Featured item',
            'type' => 'checkbox',
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
