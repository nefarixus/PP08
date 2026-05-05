<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    public $timestamps = true;

    protected $fillable = [
        'name',
        'img',
        'description',
        'price',
        'rating',
    ];

    protected $casts = [
        'price'  => 'decimal:2',
        'rating' => 'decimal:2',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_products', 'product_id', 'user_id')
            ->withTimestamps();
    }
}
