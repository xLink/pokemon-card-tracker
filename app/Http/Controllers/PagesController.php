<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Http\Request;
use App\Models\Deck;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use App\Services\PkmnCardsService;
use App\Models\Cardset;
use App\Services\PkmnTCGService;

class PagesController extends Controller
{
    public function dashboard() 
    {
        $activeSets = Cardset::where('active', 1)->count();
        $totalCards = Card::count();
        $latestCards = Card::inRandomOrder()->limit(10)->get();

        return inertia('Pages/DashboardPage', [
            'activeSetCount' => $activeSets,
            'totalCardCount' => $totalCards,
            'latestCards' => $latestCards,
        ]);
    }

    public function test()  
    {
        $card = Card::where('set_id', 'MEW')
            ->where('card_no', '025')
            ->first();
        dump($card->toArray());

        $cardInfo = (new PkmnTCGService)->getCard($card);
        dd($cardInfo);

        return [
            // 'sets' => $sets,
            'cards' => $cards,

        ];
    }
}
