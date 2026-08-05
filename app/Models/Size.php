<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Size extends Model
{
    use SoftDeletes, HasFactory;
    protected $table = 'category_sizes';
    protected $fillable = ['source',
        'size', 'size_type',  
    ];

    /***Variants table***/
    public function productsVariant() 
    { 
        return $this->belongsToMany(Product::class, "products_variants", "category_size_id", "product_id")->withPivot('stock_quantity')->withTimestamps(); 
    }
    public function colorsVariant()
    {
        return $this->belongsToMany(Color::class, 'products_variants', 'category_size_id', 'category_color_id')
                    ->withPivot('stock_quantity') 
                    ->withTimestamps(); 
    }

    /***One to one relationship with tenant***/
    public function tenant()
    {
        return $this->belongsTo(Tenant::class, "tenant_id");
    }
}
