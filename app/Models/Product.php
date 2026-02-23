<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes, HasFactory;
    protected $fillable = [
        'product_name',
        'description',
        'total_stock',
        'heel_id',
        'type_id',
    ];


    /***One to one***/
    public function type()
    {
        return $this->belongsTo(Type::class, "type_id");
    }

    public function heel()
    {
        return $this->belongsTo(Heel::class, "heel_id");
    }

    /***One to many***/
    public function prices()
    {
        return $this->hasMany(Price::class);
    }

    /***Many to many relationships with categories***/
    public function colors()
    {
        return $this->belongsToMany(Color::class, "products_colors", "product_id", "category_color_id")->withTimestamps();
    }

    public function images()
    {
        return $this->belongsToMany(Image::class, "products_colors", "product_id", "category_image_id")->withTimestamps();
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, "products_tags", "product_id", "category_tag_id")->withTimestamps();
    }

    public function genders()
    {
        return $this->belongsToMany(Gender::class, "products_genders", "product_id", "category_gender_id")->withTimestamps();
    }


    public function materials()
    {
        return $this->belongsToMany(Material::class, "products_materials", "product_id", "category_material_id")->withTimestamps();
    }

    /***Variants table***/
    public function colorsVariant()
    {
        return $this->belongsToMany(Color::class, 'products_variants', 'product_id', 'category_color_id')
            ->withPivot('stock_quantity') // Stock quantity for the product-color variant
            ->withTimestamps();
    }
    // Relationship with CategorySize via products_variants pivot table
    public function sizesVariant()
    {
        return $this->belongsToMany(Size::class, 'products_variants', 'product_id', 'category_size_id')
            ->withPivot('stock_quantity') // Stock quantity for the product-size variant
            ->withTimestamps();
    }

   /***Wishlist pivot table ("wishlist_items")***/
       public function users()
    {
        return $this->belongsToMany(User::class, "wishlist_items", "product_id", "user_id")->withPivot("price_when_added", "notified_of_discount")->withTimestamps();
    }
}
