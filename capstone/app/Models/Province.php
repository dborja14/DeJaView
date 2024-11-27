<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;

    protected $table = 'table_province';
    protected $primaryKey = 'province_id';

    public function municipalities()
    {
        return $this->hasMany(Municipality::class, 'province_id');
    }

    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id', 'id');
    }

    public function address()
    {
        return $this->hasMany(Address::class, 'pronvice_id', 'pronvice_id');
    }
}
