<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tenant extends Model
{
    use HasFactory;

    protected $table = 'tenants';

        protected $fillable = [
        'tenant_name',
        'slug',
        'logo_image_id',
        'cover_image_id',
        'currency',
        'phone',
        'shipping_provider',
        'shipping_cost',
        'free_shipping_threshold',
    ];
    protected $casts = [
        'is_active' => 'boolean',
        'shippingCost' => 'decimal:2',
        'freeShippingThreshold' => 'decimal:2',
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
    public function size()
    {
        return $this->hasOne(Size::class)->withTimestamps();
    }

    public function tag()
    {
        return $this->hasOne(Tag::class)->withTimestamps();
    }
    public function heel()
    {
        return $this->hasOne(Heel::class)->withTimestamps();
    }
    public function type()
    {
        return $this->hasOne(Type::class)->withTimestamps();
    }
}
