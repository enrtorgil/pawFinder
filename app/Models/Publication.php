<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publication extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'name', 'type', 'type_animal', 'size', 'image', 'date', 'description', 'street', 'city', 'country', 'zip', 'latitude', 'longitude'
    ];

    public function user() // Pertenece a un usuario.
    {
        return $this->belongsTo(User::class);
    }

    public function favs() // Tiene muchos favoritos (usuarios).
    {
        return $this->belongsToMany(User::class, 'favs')->withTimestamps();
    }

    public function reports() // Tiene muchos reportes (usuarios).
    {
        return $this->belongsToMany(User::class, 'reports')
            ->withPivot('additional_info', 'reason', 'created_at')
            ->withTimestamps();
    }
}
