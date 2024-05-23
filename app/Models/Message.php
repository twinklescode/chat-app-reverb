<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'sender_id',
        'receiver_id',
        'content',
        'timestamp'
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
  
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function parent()
    {
        return $this->belongsTo(Message::class, 'parent_id');
    }
}
