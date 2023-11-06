<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Deck;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use App\Services\PkmnCardsService;

class PagesController extends Controller
{
    public function dashboard()
    {
        return inertia('Pages/DashboardPage');
    }

    public function test()
    {
        DB::enableQueryLog();
        // $sets = (new PkmnCardsService)->getSetsUserHasCardsFor();
        // $cards = (new PkmnCardsService)->getCardsForUserBySet(Arr::get($sets, '3.id'));

        $cards = User::with('cards', 'cards.set')->get()->map(function($user) {
            return [
                'uuid' => $user->uuid,
                'cards' => $user->cards->toArray(),
                'sets' => $user->cards->pluck('set_id')->unique()->toArray(),
            ];

        })->toArray();
        dump(DB::getQueryLog());
        dd($cards);

        return [
            // 'sets' => $sets,
            'cards' => $cards,

        ];
    }
}
