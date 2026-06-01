<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Gender extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'category_genders';

    protected $fillable = [
        'gender',   
    ];

    /***Many to many relationship with product***/
    public function products() 
    { 
        return $this->belongsToMany(Product::class, "products_genders", "category_gender_id", "product_id")->withTimestamps(); 
    }

    /***One to one relationship with tenant***/
    public function tenant()
    {
        return $this->belongsTo(Tenant::class, "tenant_id");
    }
}
