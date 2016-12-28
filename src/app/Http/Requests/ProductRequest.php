<?php

namespace SeanDowney\BackpackStoreCrud\app\Http\Requests;

use App\Http\Requests\Request;

class ProductRequest extends \Backpack\CRUD\app\Http\Requests\CrudRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return \Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|min:2|max:255',
            'slug' => 'unique:store_products,slug,'.\Request::get('id'),
            'description' => 'required|min:2',
            'status' => 'required',
            'price_from' => 'numeric',
            'total_num' => 'numeric',
            'remaining_num' => 'numeric',
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            //
        ];
    }
}
