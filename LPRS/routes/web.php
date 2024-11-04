<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EvenementsController;
use App\Http\Controllers\OfferController;

Route::resource('evenements', EvenementsController::class);


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

