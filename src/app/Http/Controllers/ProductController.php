<?php

namespace SeanDowney\BackpackStoreCrud\app\Http\Controllers;

use SeanDowney\BackpackStoreCrud\app\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

use SeanDowney\BackpackStoreCrud\app\Http\Requests\ProductAddRequest;

class ProductController extends Controller
{
    public function index($category, $slug)
    {
        $product = Product::findBySlug($slug);

        if (!$product) {
            abort(404, 'Please go back to our <a href="'.url('').'">homepage</a>.');
        }

        $this->data['title'] = $product->title;
        $this->data['product'] = $product->withFakes();
        $this->data['images'] = $product->images;
        $this->data['options'] = $product->options();

        return view('seandowney::store.product', $this->data);
    }

}
