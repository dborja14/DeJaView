<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;

    use SoftDeletes;
    protected $table = 'products';
    

    protected $fillable = [
        'productName',
        'productCategory',
        'productPrice',
    ];

    public function features()
    {
        return $this->hasMany(Feature::class, 'productId'); // Reference to features
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'productName', 'productBrand'); // Define brand relationship based on names
    }

    public function photos()
    {
        return $this->hasMany(Photo::class, 'productId');
    }

    public function shoeSizes()
    {
        return $this->hasMany(Shoesize::class, 'productId');
    }
}
