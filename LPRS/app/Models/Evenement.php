<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function participants()
    {
        return $this->belongsToMany(User::class, 'evenement_user');
    }

    public function isUserInscrit()
    {
        return $this->participants()->where('user_id', Auth::id())->exists();
    }
}