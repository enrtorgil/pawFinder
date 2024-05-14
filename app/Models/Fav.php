<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fav extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'publication_id'
    ];

    public function user() // Pertenece a un usuario.
    {
        return $this->belongsTo(User::class);
    }

    public function publication() // Pertenece a una publicación.
    {
        return $this->belongsTo(Publication::class);
    }
}
