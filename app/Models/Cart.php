<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'carts';

    public function product()
    {
        return $this->belongsTo(Product::class, 'productId'); // Assuming 'productId' is the foreign key
    }

    public function address()
    {
        return $this->belongsTo(Address::class, 'addressId'); // Adjust 'address_id' if needed
    }
}
