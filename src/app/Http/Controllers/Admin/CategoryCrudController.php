<?php

namespace SeanDowney\BackpackStoreCrud\app\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
// VALIDATION: change the requests to match your own file names if you need form validation
use SeanDowney\BackpackStoreCrud\app\Http\Requests\CategoryRequest as StoreRequest;
use SeanDowney\BackpackStoreCrud\app\Http\Requests\CategoryRequest as UpdateRequest;

class CategoryCrudController extends CrudController
{
    public function __construct()
    {
        parent::__construct();

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel("SeanDowney\BackpackStoreCrud\app\Models\Category");
        $this->crud->setRoute(config('backpack.base.route_prefix', 'admin').'/'.config('seandowney.storecrud.route_prefix', 'store').'/category');
        $this->crud->setEntityNameStrings('Category', 'Categories');

        $this->crud->allowAccess('reorder');
        $this->crud->enableReorder('title', 1);

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
            'name' => 'featured',
            'label' => 'Featured',
            'type' => 'check',
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

        $this->crud->addField([    // WYSIWYG
            'name' => 'description',
            'label' => 'Description',
            'type' => 'ckeditor',
            'placeholder' => 'Your textarea text here',
        ]);
        $this->crud->addField([    // Image
            'name' => 'image',
            'label' => 'Image',
            'type' => 'browse',
        ]);
        $this->crud->addField([       // Select2Multiple = n-n relationship (with pivot table)
            'label' => 'Products',
            'type' => 'select2_multiple',
            'name' => 'products', // the method that defines the relationship in your Model
            'entity' => 'products', // the method that defines the relationship in your Model
            'attribute' => 'title', // foreign key attribute that is shown to user
            'model' => "SeanDowney\BackpackStoreCrud\app\Models\Product", // foreign key model
            'pivot' => true, // on create&update, do you need to add/delete pivot table entries?
        ]);
        $this->crud->addField([    // ENUM
            'name' => 'status',
            'label' => 'Status',
            'type' => 'enum',
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
