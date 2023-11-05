<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Deck;
use Illuminate\Support\Facades\DB;

class PagesController extends Controller 
{
    public function dashboard() 
    {
        return inertia('Pages/DashboardPage');
    }

    public function test() 
    {
        DB::enableQueryLog();
        $user = auth()->user();

        $cards = $user->cards()->count();
        dump($cards);
        $sets = $user->sets()->count();
        dump($sets);
        dd(DB::getQueryLog());

        return [
            // 'sets' => $user->sets()->get(),
            'cards' => $user->cards,
            
        ];
    }
} 