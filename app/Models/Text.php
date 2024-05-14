<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Text extends Model
{
    use HasFactory;

    protected $fillable = [
        'emitter_id', 'receiver_id', 'subject', 'short_description'
    ];

    public function sender() // Pertenece a un emisor (usuario).
    {
        return $this->belongsTo(User::class, 'emitter_id');
    }

    public function receiver() // Pertenece a un receptor (usuario).
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
