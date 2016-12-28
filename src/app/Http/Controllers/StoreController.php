<?php

namespace SeanDowney\BackpackStoreCrud\app\Http\Controllers;

use SeanDowney\BackpackStoreCrud\app\Models\Category;
use App\Http\Controllers\Controller;

class StoreController extends Controller
{
    public function index()
    {
        $categories = Category::published()->get();

        if (!$categories) {
            abort(404, 'Please go back to our <a href="'.url('').'">homepage</a>.');
        }

        $this->data['title'] = 'The Store';
        $this->data['categories'] = $categories;

        return view('seandowney::store.index', $this->data);
    }

    public function category($slug)
    {
        $category = Category::whereSlug($slug)->published()->first();

        if (!$category) {
            abort(404, 'Please go back to our <a href="'.url('').'">homepage</a>.');
        }

        $this->data['title'] = $category->title;
        $this->data['category'] = $category->withFakes();
        $this->data['products'] = $category->products;

        return view('seandowney::store.category', $this->data);
    }
}
