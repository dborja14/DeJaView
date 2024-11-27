<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChatContent extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'chatcontent';

    protected $fillable = ['chatId', 'content'];

    public function images()
    {
        return $this->hasMany(ChatImage::class, 'chatId', 'chatId');
    }

}
