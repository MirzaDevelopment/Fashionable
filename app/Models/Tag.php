<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use HasFactory;
    use SoftDeletes, HasFactory;
    protected $table = 'category_tags';
    protected $fillable = ['source',
        'tag',   
    ];

     /***Many to many relationship with product***/

     public function products() 
     { 
         return $this->belongsToMany(Product::class, "products_tags", "category_tag_id", "product_id")->withTimestamps(); 
     }

    /***One to one relationship with tenant***/
    public function tenant()
    {
        return $this->belongsTo(Tenant::class, "tenant_id");
    }

}
