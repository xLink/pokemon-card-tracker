<?php

namespace App\Http\Controllers;

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