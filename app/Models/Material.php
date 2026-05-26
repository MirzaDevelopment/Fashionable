<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Material extends Model
{
    use SoftDeletes, HasFactory;
   
    protected $table = 'category_materials';
    
    protected $fillable = [
        'material',

    ];

    /***Many to many relationship with product***/
    public function products()
    {
        return $this->belongsToMany(Product::class, "products_materials", "category_material_id", "product_id")->withTimestamps(); 
    }
}
