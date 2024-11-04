<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evenement extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'titre',
        'description',
        'adresse',
        'elements_requis',
        'nb_place',
        'date',
        'ref_user',
    ];

    protected $casts = [
        'date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'ref_user');
    }

    public function participants()
    {
        return $this->belongsToMany(User::class, 'evenement_user', 'evenement_id', 'user_id');
    }

    public function isUserInscrit($userId)
    {
        return $this->participants()->where('user_id', $userId)->exists();
    }
}