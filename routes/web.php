<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\DeckController;
use App\Http\Controllers\SetController;
use App\Http\Controllers\PagesController;

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

Route::get('/', [PagesController::class, 'dashboard'])->name('pages.dashboard');

Route::get('/login', [AuthController::class, 'getLogin'])->name('pages.login');
Route::post('/login', [AuthController::class, 'postLogin'])->name('pages.login');
Route::post('/logout', [AuthController::class, 'getLogout'])->name('pages.logout');
Route::get('/register', [AuthController::class, 'getRegister'])->name('pages.register');
Route::post('/register', [AuthController::class, 'postRegister']);


Route::get('/cards', [CardController::class, 'showAll'])->name('pages.cards.all');
Route::get('/cards/random', [CardController::class, 'showRandom'])->name('pages.cards.random');
Route::get('/cards/{card}/', [CardController::class, 'showSingle'])->name('pages.cards.single');

Route::get('/decks', [DeckController::class, 'showAll'])->name('pages.decks.all');
Route::get('/decks/{deck}/', [DeckController::class, 'showSingle'])->name('pages.decks.single');

Route::get('/card-sets', [SetController::class, 'showAll'])->name('pages.sets.all');
Route::get('/card-sets/{set}', [SetController::class, 'showSingle'])->name('pages.sets.single');