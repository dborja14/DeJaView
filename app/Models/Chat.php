<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chat extends Model
{
    use HasFactory;

    public function user() {
        return $this->belongsTo(User::class, 'userId'); // Assuming 'userId' is the foreign key
    }

    public function contents()
    {
        return $this->hasMany(ChatContent::class, 'chatId');
    }
    
    public function images()
    {
        return $this->hasMany(ChatImage::class, 'chatId');
    }
}
