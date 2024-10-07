<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UtilisateurController;
use App\Http\Controllers\FicheEntrepriseController;
use App\Http\Controllers\OffreController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ReponseController;
use App\Http\Controllers\EvenementController;

Route::resource('utilisateurs', UtilisateurController::class); 
Route::resource('fiche-entreprises', FicheEntrepriseController::class); 
Route::resource('offres', OffreController::class); 
Route::resource('posts', PostController::class); 
Route::resource('reponses', ReponseController::class); 
Route::resource('evenements', EvenementController::class); 


Route::get('/', function () {
    return view('welcome');
});
