<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'publication_id', 'user_id', 'additional_info', 'reason'
    ];

    public function publication() // Pertenece a una publicación.
    {
        return $this->belongsTo(Publication::class);
    }

    public function user() // Pertenece a un usuario.
    {
        return $this->belongsTo(User::class);
    }
}
