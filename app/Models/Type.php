<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Type extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'types';
    protected $fillable = [
        'type_name',
    ];

    /***One to one relationship***/
    public function product()
    {
        return $this->hasOne(Product::class)->withTimestamps();
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class, "tenant_id");
    }
}
