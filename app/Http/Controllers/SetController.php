<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cardset;

class SetController extends Controller 
{
    public function showAll() 
    {
        $sets = Cardset::paginate(20);
        return view('pages.sets', compact('sets'));
    }

    public function showSingle(Cardset $set, Request $request)
    {
        $pagination = $request->get('show', 9);
        $cards = $set->cards;
        return view('pages.set', [
            'set' => $set,
            'cards' => $set->cards()->paginate($pagination),
            'card_count' => $cards->count(),
        ]);
    }

}