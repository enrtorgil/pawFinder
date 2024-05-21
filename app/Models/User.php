<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'username', 'email', 'password', 'phone', 'role'
    ];

    public function publications() // Un usuario puede tener muchas publicaciones.
    {
        return $this->hasMany(Publication::class);
    }

    public function favs() // Un usuario puede marcar muchas publicaciones como favoritas, y una publicación puede ser marcada como favorita por muchos usuarios.
    {
        return $this->belongsToMany(Publication::class, 'favs')->withTimestamps();
    }

    public function reports() // Un usuario puede reportar muchas publicaciones, y una publicación puede ser reportada por muchos usuarios.
    {
        return $this->belongsToMany(Publication::class, 'reports')
            ->withPivot('additional_info', 'reason', 'created_at')
            ->withTimestamps();
    }

    public function sentTexts() // Un usuario puede enviar mensajes a muchos usuarios.
    {
        return $this->belongsToMany(User::class, 'texts', 'emitter_id', 'receiver_id')
            ->withPivot('subject', 'short_description', 'created_at')
            ->withTimestamps();
    }

    public function receivedTexts() // Un usuario puede recibir mensajes de muchos usuarios.
    {
        return $this->belongsToMany(User::class, 'texts', 'receiver_id', 'emitter_id')
            ->withPivot('subject', 'short_description', 'created_at')
            ->withTimestamps();
    }
}
