<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'code',
        'category',
        'name',
        'description',
        'selling_price',
        'special_price',
        'status',
        'is_delivery_available',
        'image',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function attributes()
    {
        return $this->hasMany(ProductAttribute::class);
    }
}
