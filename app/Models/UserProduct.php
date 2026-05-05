<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class UserProduct extends Pivot
{
    use HasFactory;

    protected $table = 'user_products';

    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'product_id',
    ];
}
