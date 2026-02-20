<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'content',
        'ticket_id',
        'from'
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }
}
