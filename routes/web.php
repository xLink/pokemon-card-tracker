<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CardController;
use App\Http\Controllers\DeckController;
use App\Http\Controllers\SetController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('app');
});

Route::get('/cards', [CardController::class, 'showAll'])->name('pages.cards');
Route::get('/card/{card_id}/', [CardController::class, 'showSingle'])->name('pages.card');

Route::get('/decks', [DeckController::class, 'showAll'])->name('pages.decks');
Route::get('/deck/{deck_id}/', [DeckController::class, 'showSingle'])->name('pages.deck');

Route::get('/sets', [SetController::class, 'showAll'])->name('pages.sets');
Route::get('/set/{set_id}/', [SetController::class, 'showSingle'])->name('pages.set');