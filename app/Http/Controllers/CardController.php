<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Card;

class CardController extends Controller 
{
    public function showAll() 
    {
        $cards = Card::all();

        return inertia('Pages/Cards', [
            'cards' => $cards
        ]);
    }

    public function showRandom() 
    {
        $cards = Card::inRandomOrder()->limit(9)->get();

        return inertia('Pages/Cards', [
            'title' => 'Random Cards',
            'cards' => $cards
        ]);
    }

    public function showSingle(Request $request, Card $set)
    {
        
    }

}