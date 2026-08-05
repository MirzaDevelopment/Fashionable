<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Heel extends Model
{
    use SoftDeletes, HasFactory;

    // Specify the table name
    protected $table = 'heels';

    protected $fillable = ['source',
        'heel_type',   
    ];

    /***One to one relationships***/
    public function product()
    {
        return $this->hasOne(Product::class);
    }
    public function tenant()
    {
        return $this->belongsTo(Tenant::class, "tenant_id");
    }
}
