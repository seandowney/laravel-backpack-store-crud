<?php

namespace SeanDowney\BackpackStoreCrud\app\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

class Product extends Model
{
    use CrudTrait;
    use Sluggable, SluggableScopeHelpers;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'store_products';
    protected $primaryKey = 'id';
    public $timestamps = true;
    // protected $guarded = ['id'];
    protected $fillable = ['price_group_id', 'slug', 'title', 'code', 'intro', 'description', 'images', 'status', 'price_from', 'featured', 'total_num', 'remaining_num'];
    // protected $hidden = [];
    // protected $dates = [];
    protected $casts = [
        'images'    => 'array',
        'featured'  => 'boolean',
    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'slug_or_title',
            ],
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    public function options()
    {
        $options = [];
        $price_group = $this->priceGroup;
        if ($price_group) {
            foreach ($price_group->priceOptions as $option) {
                $options[] = $option;
            }
        }

        foreach ($this->priceOptions as $option) {
            $options[] = $option;
        }

        return collect($options);
    }


    public static function findByCode(string $code)
    {
        return Product::where('code', $code)->firstOrFail();
    }


    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function priceGroup()
    {
        return $this->belongsTo('SeanDowney\BackpackStoreCrud\app\Models\PriceGroup', 'price_group_id');
    }

    public function categories()
    {
        return $this->belongsToMany('SeanDowney\BackpackStoreCrud\app\Models\Category', 'store_category_products');
    }

    public function priceOptions()
    {
        return $this->belongsToMany('SeanDowney\BackpackStoreCrud\app\Models\PriceOption', 'store_product_price_option');
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    public function scopePublished($query)
    {
        return $query->where('status', 'PUBLISHED');
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */

    // The slug is created automatically from the "title" field if no slug exists.
    public function getSlugOrTitleAttribute()
    {
        if ($this->slug != '') {
            return $this->slug;
        }

        return $this->title;
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
