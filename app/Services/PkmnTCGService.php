<?php

namespace App\Services;

use App\Models\Card;
use Illuminate\Support\Facades\Cache;
use Pokemon\Pokemon;

class PkmnTCGService {
    public function constructor() {
        Pokemon::ApiKey(env('TCG_API'));
    }

    public function getSet(String $set) {
        return Pokemon::Set()->find($set);
    }

    public function getCard(Card $card) 
    {
        $key = implode('.', [$card->set->id, $card->card_no, $card->special]);

        return Cache::remember($key, 60 * 60 * 24, function() use ($card) {
            $set = Pokemon::Set()->where(['name' =>strtolower($card->set->name)])->all();

            $card = Pokemon::Card()
                ->where(['set.id' => $set[0]->getId()])
                ->where(['number' => (int) $card->card_no])
                ->all();

            return $card[0]->toArray();
        });
    }
}