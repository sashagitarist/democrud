<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_date',
        'phone',
        'email',
        'address',
        'location',
        'order_amount',
    ];

    public function goods(): BelongsToMany
    {
        return $this->belongsToMany(Goods::class, 'order_goods')->withPivot('quantity')->withTimestamps();
    }
}
