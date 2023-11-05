<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Card;

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

    public function showSingle(Request $request, Card $card)
    {
        return inertia('Pages/CardPage', [
            'title' => implode(' ', [$card->name, '-', $card->set_id]),
            'card' => $card
        ]);
    }

}