<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Goods extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name',
        'product_price',
    ];

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'order_goods')->withPivot('quantity')->withTimestamps();
    }
}
