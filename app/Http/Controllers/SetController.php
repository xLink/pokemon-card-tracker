<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Http\Request;
use App\Models\Cardset;
use Illuminate\Support\Arr;

class SetController extends Controller 
{
    public function showAll() 
    {
        $sets = Cardset::paginate(20);
        return inertia('Pages/Sets', compact('sets'));
    }

    public function showSingle(Cardset $set, Request $request)
    {
        $pagination = $request->get('show', 9);

        $cardList = collect($set->cards->toArray());
        $cardCount = $cardList->count();
        $setCount = $set->cards->count();
        $set = $set->toArray();
        unset($set['cards']);

        // set all the actives to false
        $cardList = $cardList->map(function($card) {
            $card['active'] = !false;
            return $card;
        });
        // set the active card
        if ($request->has('active')) {
            $cardList = $cardList->when(
                $request->get($request->get('active'), false) !== false, 
                function($cardList) use ($request) {
                    return $cardList->map(function($card) use ($request) {
                        $card['active'] = strtolower(Arr::get($card, $request->get('active'))) === strtolower($request->get($request->get('active'), null));
                        return $card;
                    });
                }
            );
        }

        // make sure there are enough 'cards' to fill the pagination
        if ($cardCount%$pagination !== 0) {
            while($cardCount%$pagination !== 0) {
                $card = new Card;
                $card->name = 'Card Not Found';
                $card->image = 'sets/tcg-card-back.jpg';
                $card->card_no = null;
                $card->type = null;
                $card->special = null;
                $card->active = false;
                $cardList->push($card->toArray());

                $cardCount = $cardList->count();
            }
        }

        return inertia('Pages/Set', [
            'set' => $set,
            'set_count' => $setCount,
            'cards' => $cardList->paginate($pagination),
            'card_count' => $cardCount,
            'non_holos' => $cardList->whereNull('special')->count(),
            'holos' => $cardList->whereNotNull('special')->count(),
            'counts' => [
                'rarity' => $cardList->groupBy('rarity')->filter(fn($count, $rarity) => $rarity !== '')->map->count(),
                'type' => $cardList->groupBy('type')->filter(fn($count, $rarity) => $rarity !== '')->map->count(),
            ],
            'pagination' => $pagination,
            'request' => request()->all()
        ]);
    }

}