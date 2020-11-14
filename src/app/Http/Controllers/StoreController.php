<?php

namespace SeanDowney\BackpackStoreCrud\app\Http\Controllers;

use SeanDowney\BackpackStoreCrud\app\Models\Category;
use App\Http\Controllers\Controller;
use SeanDowney\BackpackStoreCrud\app\Models\Product;

class StoreController extends Controller
{
    public function index()
    {
        $categories = Category::published()->orderBy('lft')->get();

        if (!$categories) {
            abort(404, 'Please go back to our <a href="'.url('').'">homepage</a>.');
        }

        $this->data['title'] = 'The Store';
        $this->data['categories'] = $categories;

        return view('seandowney::frontend.index', $this->data);
    }

    public function category($slug)
    {
        $category = Category::whereSlug($slug)->published()->first();

        if (!$category) {
            abort(404, 'Please go back to our <a href="'.url('').'">homepage</a>.');
        }

        $this->data['title'] = $category->title;
        $this->data['category'] = $category->withFakes();
        $this->data['products'] = $category->products()->published()->orderBy('order')->get();

        return view('seandowney::frontend.category', $this->data);
    }


    public function product($category, $slug)
    {
        $category = Category::whereSlug($category)->published()->first();
        $product = Product::whereSlug($slug)->published()->first();

        if (!$product) {
            abort(404, 'Please go back to our <a href="'.url('').'">homepage</a>.');
        }

        $this->data['title'] = $product->title;
        $this->data['category'] = $category->withFakes();
        $this->data['product'] = $product->withFakes();
        $this->data['images'] = $product->images;
        $this->data['options'] = $product->options();

        return view('seandowney::frontend.product', $this->data);
    }
}
