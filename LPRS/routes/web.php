<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EvenementController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\DiscussionController;
use App\Http\Controllers\ReplyController;



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

    // Forum et discussions
    Route::get('/forum', [DiscussionController::class, 'index'])->name('forum.index'); // Page principale du forum
    Route::get('/discussions/create', [DiscussionController::class, 'create'])->name('discussions.create'); // Formulaire de création
    Route::post('/discussions', [DiscussionController::class, 'store'])->name('discussions.store'); // Sauvegarde de la discussion
    Route::resource('discussions', DiscussionController::class)->except(['index', 'create', 'store']);
    Route::resource('discussions', DiscussionController::class);
    Route::resource('replies', ReplyController::class);
    Route::post('/replies', [ReplyController::class, 'store'])->name('replies.store');

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

