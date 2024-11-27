<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Municipality extends Model
{
    use HasFactory;

    protected $table = 'table_municipality';

    public function barangays()
    {
        return $this->hasMany(Barangay::class, 'municipality_id');
    }

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id', 'id');
    }

    public function address()
    {
        return $this->hasMany(Address::class, 'municipality_id', 'municipality_id');
    }
}
