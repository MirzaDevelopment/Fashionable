<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends Model
{
    use HasFactory;

    protected $table = 'category_images';
    protected $fillable = ['image_type',
        'image_path', 'image_200x200', 'image_320x320','image_400x400', 'image_800x800', 'image_1200x1200'
    ];
    
    /***Many to many relationship with product***/
    public function products() 
    { 
        return $this->belongsToMany(Product::class, "products_colors", "category_image_id", "product_id")->withTimestamps(); 
    }
     /***Many to many relationship with color***/
     public function colors() 
     { 
         return $this->belongsToMany(Color::class, "products_colors", "category_image_id", "category_color_id")->withTimestamps(); 
     }

    /***One to one relationship with tenant***/
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
}
