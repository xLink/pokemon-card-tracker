<?php

namespace App\Http\Controllers;

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