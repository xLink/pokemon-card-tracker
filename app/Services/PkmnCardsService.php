<?php

namespace App\Services;

use App\Models\Card;
use App\Models\Cardset;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Weidner\Goutte\GoutteFacade as Goutte;

class PkmnCardsService {

    public static function getSetListing(): Collection
    {
        $sets = collect();

        $crawler = Goutte::request('GET', 'https://pkmncards.com/sets/');
        $crawler->filter('.entry-content li a')->each(function ($node) use(&$sets) {
          $sets->push([
            'name' => $node->text(),
            'code' => $node->attr('href')
          ]);
        });

        return $sets;
    }

    public static function importSet($set): Collection
    {
        $cards = collect();
        $crawler = Goutte::request('GET', $set['code'].'?sort=date&ord=auto&display=list');
        $crawler->filter('.type-pkmn_card.entry')->each(function ($node) use(&$cards) {
            $card = $node->filter('.cell')->each(function ($node) {
                return $node->text();
            });

            if (count($card) > 1) {
                $card_type = explode(' › ', $card[3]);
                $cards->push([
                    'set' => $card[0],
                    'number' => $card[1],
                    'name' => self::getType($card[2]),
                    'card_type' => last($card_type),
                    'type' => self::getType($card[4]),
                    'rarity' => $card[5],
                    'url' => $node->filter('.cell a')->attr('href')
                ]);
            }
        });

        $activeSet = Cardset::firstOrCreate([
            'name' => $set['name'],
        ],[
            'id' => $cards->first()['set'],
        ]);

        // save the cards to the database
        foreach ($cards as $card) {
            dump('Importing '.$card['name'].'...');
            $crawler = Goutte::request('GET', $card['url']);
            $imageUrl = $crawler->filter('a[title="Download Image"]')->attr('href');

            $dirPath = implode('/', [
                'sets',
                $activeSet->id
            ]);
            $cardPath = implode('/', [
                $dirPath,
                basename($imageUrl)
            ]);
            if(!file_exists(public_path($dirPath))) {
                mkdir(public_path($dirPath), 755, true);
            }
            if(!file_exists(public_path($cardPath))) {
                dump('Downloading card image...');
                file_put_contents(
                    public_path($cardPath), 
                    file_get_contents($imageUrl)
                );
            }

            Card::firstOrCreate([
                'card_no' => $card['number'],
                'set_id' => $activeSet->id,
            ],[
                'id' => Str::uuid(),
                'name' => $card['name'],
                'card_type' => $card['card_type'],
                'type' => $card['type'] ?? null,
                'rarity' => $card['rarity'],
                'image' => $cardPath
            ]);
        }

        return Cardset::find($activeSet->id)->cards;
    }
    
    private static function getType($type) 
    {
        $types = [
            '{G}' => 'Grass',
            '{R}' => 'Fire',
            '{W}' => 'Water',
            '{L}' => 'Lightning',
            '{P}' => 'Psychic',
            '{F}' => 'Fighting',
            '{D}' => 'Darkness',
            '{M}' => 'Metal',
            '{N}' => 'Dragon',
            '{Y}' => 'Fairy',
            '{C}' => 'Colorless',        
        ];

        return str_replace(array_keys($types), array_values($types), $type);
    }

}
