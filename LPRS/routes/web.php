<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EvenementController;
use App\Http\Controllers\OfferController;

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/evenements', [EvenementController::class, 'index'])->name('evenements.index');
    Route::get('/evenements/create', [EvenementController::class, 'create'])->name('evenements.create');
    Route::post('/evenements', [EvenementController::class, 'store'])->name('evenements.store');
    Route::get('/evenements/{evenement}', [EvenementController::class, 'show'])->name('evenements.show');
    Route::get('/evenements/{evenement}/edit', [EvenementController::class, 'edit'])->name('evenements.edit');
    Route::put('/evenements/{evenement}', [EvenementController::class, 'update'])->name('evenements.update');
    Route::delete('/evenements/{evenement}', [EvenementController::class, 'destroy'])->name('evenements.destroy');
    
    Route::get('/evenements/{evenement}/participants', [EvenementController::class, 'participants'])->name('evenements.participants');
    Route::post('/evenements/{evenement}/inscription', [EvenementController::class, 'inscription'])->name('evenements.inscription');
    Route::delete('/evenements/{evenement}/desinscription', [EvenementController::class, 'desinscription'])->name('evenements.desinscription');
    

    
});
    


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

