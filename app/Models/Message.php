<?php

namespace App\Models;

use Database\Factories\MessageFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    /** @use HasFactory<MessageFactory> */
    use HasFactory;

    protected $fillable = [
        'message_id',
        'chat_jid',
        'sender_name',
        'body',
        'is_from_me',
        'received_at',
    ];

    protected function casts(): array
    {
        return [
            'is_from_me' => 'boolean',
            'received_at' => 'datetime',
        ];
    }

    protected function preview(): Attribute
    {
        return Attribute::get(fn () => str($this->body)->limit(60));
    }
}
