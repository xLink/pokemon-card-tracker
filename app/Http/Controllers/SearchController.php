<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Http\Request;
use App\Models\Cardset;
use Illuminate\Support\Arr;
use App\Services\PkmnCardsService;

class SearchController extends Controller 
{

    public function index(Request $request)
    {
        $search = $request->get('search', null);
        if ($search === null) {
            return inertia('Pages/Search/Index', [
                'search' => $search,
            ]);
        }

        $pagination = $request->get('show', default: 9);
        $cards = (new PkmnCardsService)->getCardsForUserBySearch($search);

        $cardList = collect($cards->toArray());
        $setCount = $cardList->count();
        $collected = $cardList->where('collected', 1)->count();
        $notHolos = $cardList->whereNull('special')->count();
        $holos = $cardList->whereNotNull('special')->count();
        $countRarity = $cardList->groupBy('rarity')->filter(fn($count, $rarity) => $rarity !== '')->map->count();
        $countEType = $cardList->groupBy('type')->filter(fn($count, $type) => $type !== '')->map->count();
        $countCType = $cardList->groupBy('card_type')->filter(fn($count, $card_type) => $card_type !== '')->map->count();

        $cardList = (new PkmnCardsService)->makeCardsActive($cardList, $request);
        $showUnselected = $request->get('hide', 'false');
        $active = $request->get('active', null);
        if ($showUnselected === 'false' || $active !== null) {
            $cardList = $cardList->filter(fn($card) => $card->active === true);
        }
        
        $cardList = (new PkmnCardsService)->makeCardsDivisibleBy($cardList, $pagination);

        $cardCount = $cardList->count();

        return inertia('Pages/Search/CardSearch', [
            'search' => $search,
            'pagination' => $pagination,
            // 'set' => $set->toArray(),
            'set_count' => $setCount,
            'cards' => $cardList->paginate($pagination),
            'card_count' => $cardCount,
            'collected' => $collected,
            'not_collected' => $setCount - $collected,
            'non_holos' => $notHolos,
            'holos' => $holos,
            'counts' => [
                'rarity' => $countRarity,
                'etype' => $countEType,
                'ctype' => $countCType,
            ],
            'request' => request()->all()
        ]);
    }
}