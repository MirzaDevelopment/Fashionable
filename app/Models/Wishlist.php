<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;

    protected $table = 'wishlist_items';

    protected $fillable = [
    'user_id',
    'product_id',
    'price_when_added',
];

    protected $casts = [
    'notified_of_discount' => 'boolean',
];

   /***One to one relationship***/
   
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
