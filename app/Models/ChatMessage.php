<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChatMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'chat_session_id',
        'sender_type',
        'sender_name',
        'message',
        'is_deal_card',
        'deal_payload',
        'is_read',
    ];

    protected function casts(): array
    {
        return [
            'is_deal_card' => 'boolean',
            'deal_payload' => 'array',
            'is_read' => 'boolean',
        ];
    }

    /**
     * Relationship: The chat session this message belongs to.
     */
    public function session(): BelongsTo
    {
        return $this->belongsTo(ChatSession::class, 'chat_session_id');
    }
}
