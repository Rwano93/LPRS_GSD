<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EvenementController;
use App\Http\Controllers\OfferController;

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::resource('evenements', EvenementController::class);
    Route::get('/evenements', [EvenementController::class, 'index'])->name('evenements.index');   
    Route::get('/evenements/create', [EvenementController::class, 'create'])->name('evenements.create');
    Route::post('/evenements', [EvenementController::class, 'store'])->name('evenements.store');
    Route::get('/evenements/{evenement}', [EvenementController::class, 'show'])->name('evenements.show');
    Route::get('/evenements/{evenement}/edit', [EvenementController::class, 'edit'])->name('evenements.edit');
    Route::put('/evenements/{evenement}', [EvenementController::class, 'update'])->name('evenements.update');
    Route::get('/evenements/{evenement}/participants', [EvenementController::class, 'participants'])->name('evenements.participants');
    Route::post('/evenements/{evenement}/inscription', [EvenementController::class, 'inscription'])->name('evenement.inscription');
    Route::delete('/evenements/{evenement}/desinscription', [EvenementController::class, 'desinscription'])->name('evenement.desinscription');
    Route::get('/evenements/{evenement}/inscrits', [EvenementController::class, 'getInscrits'])->name('evenements.inscrits');});
    


Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
    
Route::resource('offers', OfferController::class)->middleware(['auth:sanctum', 'verified']);

