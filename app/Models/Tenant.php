<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tenant extends Model
{
    use HasFactory;

    protected $table = 'tenants';


    protected $casts = [
        'is_active' => 'boolean',
        'shipping_cost' => 'decimal:2',
        'free_shipping_threshold' => 'decimal:2',
    ];

    /***One to many***/
    public function images()
    {
        return $this->hasMany(Image::class);
    }

    /***One to one relationships***/
    public function product()
    {
        return $this->hasOne(Product::class)->withTimestamps();
    }

    public function user()
    {
        return $this->hasOne(User::class)->withTimestamps();
    }

    public function color()
    {
        return $this->hasOne(Color::class)->withTimestamps();
    }
    public function gender()
    {
        return $this->hasOne(Gender::class)->withTimestamps();
    }

    public function material()
    {
        return $this->hasOne(Material::class)->withTimestamps();
    }
}
