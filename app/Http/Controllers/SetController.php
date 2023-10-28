<?php

namespace App\Http\Controllers;

use App\Models\Card;
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

        $cardList = collect($set->cards->toArray());
        $cardCount = $cardList->count();

        // make sure there are enough 'cards' to fill the pagination
        if ($cardCount%$pagination !== 0) {
            while($cardCount%$pagination !== 0) {
                $card = new Card;
                $card->name = 'Card Not Found';
                $card->image = 'sets/tcg-card-back.jpg';
                $card->special = null;
                $cardList->push($card->toArray());

                $cardCount = $cardList->count();
            }
        }

        return view('pages.set', [
            'set' => $set,
            'cards' => $cardList->paginate($pagination),
            'set_count' => $set->cards->count(),
            'card_count' => $cardCount,
            'non_holos' => $cardList->whereNull('special')->count(),
            'holos' => $cardList->whereNotNull('special')->count(),
        ]);
    }

}