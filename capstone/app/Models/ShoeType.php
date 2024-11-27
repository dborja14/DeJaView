<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShoeType extends Model
{
    use HasFactory;

    protected $table = 'shoetype';

    protected $fillable = ['name'];

    public function features()
    {
        return $this->hasMany(Feature::class);
    }
}