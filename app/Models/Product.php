<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'description',
        'price',
        'img',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_products', 'product_id', 'user_id');
    }
}
