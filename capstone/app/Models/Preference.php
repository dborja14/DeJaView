<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Preference extends Model
{
    use HasFactory;

    protected $table = 'preferences';

    protected $fillable = [
        'q1','q2','q3','q4','q5','q6'
    ];
    
    // Define the relationship with the `shoetype` table
    public function shoetype()
    {
        return $this->belongsTo(ShoeType::class, 'q2', 'id');
    }

    // Define other relationships if needed (e.g., fits)
    public function fit()
    {
        return $this->belongsTo(Fit::class, 'q3', 'id');
    }
}
