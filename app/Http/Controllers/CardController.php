<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Card;

class CardController extends Controller 
{
    public function showAll() 
    {
        return view('pages.cards');
    }

    public function showSingle(Request $request, Card $set)
    {
        
    }

}