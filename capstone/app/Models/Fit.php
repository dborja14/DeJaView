<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fit extends Model
{
    use HasFactory;

    protected $table = 'fits';
    protected $fillable = ['name'];

    public function features()
    {
        return $this->hasMany(Feature::class);
    }
}
