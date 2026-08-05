<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Color extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'category_colors';
    protected $fillable = ['source',
        'color', 'hex_code',
    ];


    /***Many to many relationship with product***/
    public function products()
    {
        return $this->belongsToMany(Product::class, "products_colors", "category_color_id", "product_id")->withTimestamps();
    }

    /***Many to many relationship with Images***/
    public function images()
    {
        return $this->belongsToMany(Image::class, "products_colors", "category_color_id", "category_image_id")->withTimestamps();
    }


    /***Variants pivot table***/
    public function productsVariant()
    {
        return $this->belongsToMany(Product::class, 'products_variants', 'category_color_id', 'product_id')
            ->withPivot('stock_quantity')
            ->withTimestamps();
    }

    public function sizesVariant()
    {
        return $this->belongsToMany(Size::class, 'products_variants', 'category_color_id', 'category_size_id')
            ->withPivot('stock_quantity') // Access stock_quantity from pivot
            ->withTimestamps();
    }

    /***One to one relationship with tenant***/
    public function tenant()
    {
        return $this->belongsTo(Tenant::class, "tenant_id");
    }
}
