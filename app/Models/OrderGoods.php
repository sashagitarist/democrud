<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderGoods extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'goods_id',
        'quantity'
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function goods(): BelongsTo
    {
        return $this->belongsTo(Goods::class);
    }
}
