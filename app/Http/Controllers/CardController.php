<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Card;
use App\Services\PkmnCardsService;

class CardController extends Controller 
{
    public function showAll() 
    {
        $cards = Card::all();

        return inertia('Pages/CardsPage', [
            'title' => 'All Cards',
            'cards' => $cards
        ]);
    }

    public function showRandom() 
    {
        $cards = Card::inRandomOrder()->limit(9)->get();

        return inertia('Pages/CardsPage', [
            'title' => 'Random Cards',
            'cards' => $cards
        ]);
    }

    public function showSingle(Card $card)
    {
        return inertia('Pages/CardPage', [
            'title' => implode(' ', [$card->name, '-', $card->set_id]),
            'card' => $card
        ]);
    }

    public function toggleCollected(Card $card)
    {
        if (auth()->user() == null) {
            return response()->abort(403);
        }

        return (new PkmnCardsService)->toggleCollectedForCards($card, auth()->user());
    }
}