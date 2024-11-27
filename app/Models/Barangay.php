<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barangay extends Model
{
    use HasFactory;

    protected $table = 'table_barangay';

    public function municipality()
    {
        return $this->belongsTo(Municipality::class, 'municipality_id', 'id');
    }

    public function address()
    {
        return $this->hasMany(Address::class, 'barangay_id', 'barangay_id');
    }
}
