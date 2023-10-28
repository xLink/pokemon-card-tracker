<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Deck;

class DeckController extends Controller 
{
    public function showAll() 
    {
        return view('pages.decks');
    }

    public function showSingle(Request $request, Deck $set)
    {

    }

}