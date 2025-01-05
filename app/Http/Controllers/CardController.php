<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Card;
use App\Services\PkmnCardsService;
use App\Services\PkmnTCGService;
use App\Models\Cardset;
use App\Models\User;

class CardController extends Controller 
{
    public function showAll() 
    {
        $cards = Card::all();

        return inertia('Pages/TCG/CardsPage', [
            'title' => 'All Cards',
            'cards' => $cards
        ]);
    }

    public function showRandom() 
    {
        $cards = Card::inRandomOrder()
            ->limit(9)
            ->get()
            ->map(function($card) {
                $card->active = true;
                return $card;
            })
        ;

        return inertia('Pages/TCG/CardsPage', [
            'title' => 'Random Cards',
            'cards' => $cards
        ]);
    }

    public function showSingle(Card $card)
    {
        return inertia('Pages/TCG/CardPage', [
            'title' => implode(' ', [$card->set_id, '-', $card->name]),
            'card' => $card
        ]);
    }

    public function showCardBySet(Cardset $set, Int $cardNo)
    {
        $card = Card::where('set_id', $set->id)
            ->where('card_no', $cardNo)
            ->firstOrFail();

        $cardInfo = (new PkmnTCGService)->getCard($card);

        return inertia('Pages/TCG/CardPage', [
            'title' => implode(' ', [$card->set_id, '-', $card->name, '(#' . $card->card_no . ')']),
            'card' => $card,
            'cardInfo' => $cardInfo
        ]);
    }

    public function compareCardSetCollections(Cardset $set, Int $user1, Int $user2, Request $request)
    {

        $pagination = $request->get('pagination', '9');

        $user1 = User::where('friend_id', $user1)->firstOrFail();
        $user1_cards = (new PkmnCardsService)->getCardsForUserBySet($set, $user1);

        $user2 = User::where('friend_id', $user2)->firstOrFail();
        $user2_cards = (new PkmnCardsService)->getCardsForUserBySet($set, $user2);

        $cardList = $set->cards()->get()
            ->map(function($card) use ($user1_cards, $user2_cards) {
                $card->active = true;
                $card->user1_collected = $user1_cards->where('id', $card->id)->first()->collected ? true : false;
                $card->user2_collected = $user2_cards->where('id', $card->id)->first()->collected ? true : false;
                return $card;
            });

        $setCount = $cardList->count();
        $collected = 0;
        $notHolos = $cardList->whereNull('special')->count();
        $holos = $cardList->whereNotNull('special')->count();
        $countRarity = $cardList->groupBy('rarity')->filter(fn($count, $rarity) => $rarity !== '')->map->count();
        $countEType = $cardList->groupBy('type')->filter(fn($count, $type) => $type !== '')->map->count();
        $countCType = $cardList->groupBy('card_type')->filter(fn($count, $card_type) => $card_type !== '')->map->count();
        $user1_collected = $cardList->where('user1_collected', true)->count();
        $user2_collected = $cardList->where('user2_collected', true)->count();
        $both_collected = $cardList->where('user1_collected', true)->where('user2_collected', true)->count();
        $non_collected = $cardList->where('user1_collected', false)->where('user2_collected', false)->count();
        $user1_missing = $cardList->where('user1_collected', false)->count();
        $user2_missing = $cardList->where('user2_collected', false)->count();

        $cardList = (new PkmnCardsService)->makeCardsActive($cardList, $request);
        
        $active = $request->get('active');
        if (in_array($active, ['user1_collected', 'user2_collected'])) {
            $cardList = $cardList->filter(function($card) use ($active) {
                return $card->$active;
            });
        }
        if ($active === 'both_collected') {
            $cardList = $cardList->filter(function($card) {
                return $card->user1_collected && $card->user2_collected;
            });
        }
        if ($active === 'non_collected') {
            $cardList = $cardList->filter(function($card) {
                return !$card->user1_collected && !$card->user2_collected;
            });
        }
        if ($active === 'user1_missing') {
            $cardList = $cardList->filter(function($card) {
                return !$card->user1_collected;
            });
        }
        if ($active === 'user2_missing') {
            $cardList = $cardList->filter(function($card) {
                return !$card->user2_collected;
            });
        }

        $cardCount = $cardList->count();

        return inertia('Pages/TCG/CompareSetCards', [
            'pagination' => $pagination,
            'set' => $set->toArray(),
            'set_count' => $setCount,
            'cards' => $cardList,
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
            'title' => implode(' ', ['Comparing', $set->name.':', ($user1->name ?? $user1->friend_id), 'vs', ($user2->name ?? $user2->friend_id)]),

            'compare_user' => true,
            'user1' => $user1->only('name', 'friend_id'),
            'user1_collected' => $user1_collected,
            'user2' => $user2->only('name', 'friend_id'),
            'user2_collected' => $user2_collected,
            'both_collected' => $both_collected,
            'non_collected' => $non_collected,
            'user1_missing' => $user1_missing,
            'user2_missing' => $user2_missing,
        ]);
    }

    public function toggleCollected(Card $card)
    {
        if (auth()->user() == null) {
            return response()->abort(403);
        }

        return (new PkmnCardsService)->toggleCollectedForCards($card, auth()->user());
    }
}