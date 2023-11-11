<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Deck;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use App\Services\PkmnCardsService;
use App\Models\Cardset;

class PagesController extends Controller
{
    public function dashboard()
    {
        return inertia('Pages/DashboardPage');
    }

    public function test()
    {
        // \DB::enableQueryLog();

        $set = Cardset::find('OBF');
        $cards = (new PkmnCardsService)->getCardsForUserBySet($set);

        // dump(\DB::getQueryLog());
        return [
            // 'sets' => $sets,
            'cards' => $cards,

        ];
    }
}
