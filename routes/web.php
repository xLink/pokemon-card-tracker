<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\DeckController;
use App\Http\Controllers\SetController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\PokedexController;
use App\Http\Controllers\SearchController;

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

Route::get('/test', [PagesController::class, 'test']);


Route::group(['prefix' => '/cards'], function($router) {
    Route::get('/', [CardController::class, 'showAll'])->name('pages.cards.all');
    Route::get('/random', [CardController::class, 'showRandom'])->name('pages.cards.random');
    Route::get('/{card}/', [CardController::class, 'showSingle'])->name('pages.cards.single')->whereUuid('card');
    Route::post('/{card}/collect', [CardController::class, 'toggleCollected'])->name('pages.cards.collect')->whereUuid('card');
});

Route::group(['prefix' => '/decks'], function($router) {
    Route::get('/', [DeckController::class, 'showAll'])->name('pages.decks.all');
    Route::get('/{deck}/', [DeckController::class, 'showSingle'])->name('pages.decks.single')->whereUuid('deck');
});

Route::group(['prefix' => '/card-sets'], function($router) {
    Route::get('/', [SetController::class, 'showAll'])->name('pages.sets.all');
    Route::get('/{set}', [SetController::class, 'showSingle'])->name('pages.sets.single')->whereAlphaNumeric('set');
    Route::get('/{set}/list', [SetController::class, 'showSingleList'])->name('pages.sets.single-list')->whereAlphaNumeric('set');
    Route::get('/{set}/{card}', [CardController::class, 'showCardBySet'])->name('pages.cards.single')->whereAlphaNumeric('set')->whereNumber('card');
    Route::get('/{set}/compare/{user1}/{user2}', [CardController::class, 'compareCardSetCollections'])->name('pages.set.compare')->whereAlphaNumeric('set')->whereNumber('user1')->whereNumber('user2');
});

Route::group(['prefix' => '/pokedex'], function($router) {
    Route::get('/', [PokedexController::class, 'index'])->name('pages.pokedex.index');
    Route::get('/{nat_dex}', [PokedexController::class, 'pokemon'])->name('pages.pokedex.pokemon')->whereNumber('nat_dex');
});


Route::group(['prefix' => '/search'], function($router) {
    Route::get('/', [SearchController::class, 'index'])->name('pages.search.index');
    Route::get('/{query}', [SearchController::class, 'search'])->name('pages.search.search')->whereAlphaNumeric('query');
});

