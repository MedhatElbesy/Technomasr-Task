<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'product_id',
        'user_id',
        'quantity',
    ];
    public function orderitems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
