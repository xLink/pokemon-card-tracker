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
        $cards = (new PkmnCardsService)->getCardsForUserBySet($set, auth()->user());

        $cardList = collect($cards->toArray());
        $setCount = $cardList->count();
        $collected = $cardList->where('collected', 1)->count();

        $cardList = (new PkmnCardsService)->makeCardsActive($cardList, $request);
        $cardList = (new PkmnCardsService)->makeCardsDivisibleBy($cardList, $pagination);

        $cardCount = $cardList->count();

        return inertia('Pages/SetPage', [
            'pagination' => $pagination,
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
                'etype' => $cardList->groupBy('type')->filter(fn($count, $type) => $type !== '')->map->count(),
                'ctype' => $cardList->groupBy('card_type')->filter(fn($count, $card_type) => $card_type !== '')->map->count(),
            ],
            'pagination' => $pagination,
            'request' => request()->all()
        ]);
    }

    public function showSingleList(Cardset $set, Request $request)
    {
        $pagination = $request->get('show', 9);
        $cards = (new PkmnCardsService)->getCardsForUserBySet($set, auth()->user());

        $cardList = collect($cards->toArray());
        $setCount = $cardList->count();
        $collected = $cardList->where('collected', 1)->count();

        $cardList = (new PkmnCardsService)->makeCardsActive($cardList, $request);

        $cardCount = $cardList->count();

        return inertia('Pages/SetListPage', [
            'pagination' => $pagination,
            'set' => $set,
            'set_count' => $setCount,
            'cards' => $cardList,
            'card_count' => $cardCount,
            'collected' => $collected,
            'not_collected' => $setCount - $collected,
            'non_holos' => $cardList->whereNull('special')->count(),
            'holos' => $cardList->whereNotNull('special')->count(),
            'counts' => [
                'rarity' => $cardList->groupBy('rarity')->filter(fn($count, $rarity) => $rarity !== '')->map->count(),
                'etype' => $cardList->groupBy('type')->filter(fn($count, $type) => $type !== '')->map->count(),
                'ctype' => $cardList->groupBy('card_type')->filter(fn($count, $card_type) => $card_type !== '')->map->count(),
            ],
        ]);
    }
}