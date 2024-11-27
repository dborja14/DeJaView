<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatImage extends Model
{
    use HasFactory;

    protected $table = 'chatImages';

    public function chat()
    {
        return $this->belongsTo(Chat::class, 'chatId');
    }

    public function chatContent()
    {
        return $this->belongsTo(ChatContent::class, 'chatId', 'chatId');
    }
}
