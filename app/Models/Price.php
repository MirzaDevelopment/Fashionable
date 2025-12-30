<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Price extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'product_id',
        'price',
        'discount',
        'start_date',
        'end_date',
    ];
    /***One to one relationship with product***/
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
