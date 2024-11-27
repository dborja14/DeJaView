<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class, 'userId'); 
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'productId')->withTrashed(); // Assuming orders are related to products
    }

    public function orderItems()
    {
        return $this->hasMany(Order::class); // Adjust the class name if necessary
    }
}
