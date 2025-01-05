<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Deck;

class DeckController extends Controller 
{
    public function showAll() 
    {
        return inertia('Pages/TCG/DecksPage');
    }

    public function showSingle(Request $request, Deck $set)
    {

    }

}