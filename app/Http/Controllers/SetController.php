<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Http\Request;
use App\Models\Cardset;
use Illuminate\Support\Arr;
use App\Services\PkmnCardsService;

class SetController extends Controller 
{
    public function showAll() 
    {
        $sets = Cardset::paginate(20);
        return inertia('Pages/SetsPage', compact('sets'));
    }

    public function showSingle(Cardset $set, Request $request)
    {
        $pagination = $request->get('show', 9);

        // if (auth()->user() !== null) {
            $cards = (new PkmnCardsService)->getCardsForUserBySet($set);
        // } else {
        //     $cards = $set->cards()->get();
        // }

        $cardList = collect($cards->toArray());
        $setCount = $cardList->count();
        $collected = $cardList->where('collected', 1)->count();

        $cardList = (new PkmnCardsService)->makeCardsActive($cardList, $request);
        $cardList = (new PkmnCardsService)->makeCardsDivisibleBy($cardList, $pagination);

        $cardCount = $cardList->count();

        return inertia('Pages/SetPage', [
            'set' => $set->toArray(),
            'set_count' => $setCount,
            'cards' => $cardList->paginate($pagination),
            'card_count' => $cardCount,
            'collected' => $collected,
            'not_collected' => $setCount - $collected,
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

    public function showSingleList(Cardset $set, Request $request)
    {
        $cards = (new PkmnCardsService)->getCardsForUserBySet($set);

        $cardList = collect($cards->toArray());
        $setCount = $cardList->count();
        $collected = $cardList->where('collected', 1)->count();

        $cardList = (new PkmnCardsService)->makeCardsActive($cardList, $request);

        $cardCount = $cardList->count();

        return inertia('Pages/SetListPage', [
            'set' => $set,
            'set_count' => $setCount,
            'cards' => $cardList,
            'card_count' => $cardCount,
            'collected' => $collected,
            'not_collected' => $setCount - $collected,
            'non_holos' => $cardList->whereNull('special')->count(),
            'holos' => $cardList->whereNotNull('special')->count(),
        ]);
    }

}