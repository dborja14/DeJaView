<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;

    protected $table = 'table_region';
    protected $primaryKey = 'region_id';

    public function provinces()
    {
        return $this->hasMany(Province::class, 'region_id');
    }

    public function address()
    {
        return $this->hasMany(Address::class, 'region_id', 'region_id');
    }
}
