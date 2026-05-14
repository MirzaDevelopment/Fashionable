<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, SoftDeletes, HasFactory, Notifiable; 

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

     /***One to one relationship***/
        public function tenant()
    {
        return $this->belongsTo(Tenant::class, "tenant_id");
    }

     /***Wishlist pivot table ("wishlist_items")***/
    public function products() 
    { 
        return $this->belongsToMany(Product::class, "wishlist_items", "user_id", "product_id")->withPivot("price_when_added", "notified_of_discount")->withTimestamps(); 
    }
}
