<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    use HasFactory;

    protected $table = 'features';

    protected $fillable = [
        'productId',
        'fitId',
        'typeId',
        'outdoorUse',
        'brandId', // Add brandId to fillable properties
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'productId'); // Reference to product
    }

    public function fit()
    {
        return $this->belongsTo(Fit::class, 'fitId'); // Reference to fit
    }

    public function type()
    {
        return $this->belongsTo(ShoeType::class, 'typeId'); // Reference to shoetype
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brandId'); // Reference to brand
    }
}
