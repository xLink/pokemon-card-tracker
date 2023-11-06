<?php

namespace App\Services;

use App\Models\Card;
use App\Models\Cardset;
use App\Models\UserCards;
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
            'name' => str_replace(' ('.$cards->first()['set'].')', '', $set['name']),
        ],[
            'id' => $cards->first()['set'],
        ]);

        $rarities = [
            'Common' => 0,
            'Uncommon' => 1,
            'Rare' => 2,
            'Double Rare' => 3,
            'Ultra Rare' => 4,
            'Illustration Rare' => 5,
            'Special Illustration Rare' => 6,
            'Hyper Rare' => 7,
        ];

        // save the cards to the database
        foreach ($cards as $card) {
            dump('Importing '.$card['name'].'...');
            dump($card);
            $crawler = Goutte::request('GET', $card['url']);
            $imageUrl = $crawler->filter('a[title="Download Image"]')->attr('href');

            $dirPath = implode('/', [
                'sets',
                $activeSet->id
            ]);
            $cardPath = implode('/', [
                $dirPath,
                $card['number'].'.'.pathinfo($imageUrl)['extension']
            ]);
            if(!file_exists(public_path($dirPath))) {
                mkdir(public_path($dirPath), 0755, true);
            }
            if(!file_exists(public_path($cardPath))) {
                dump('Downloading card image...');
                file_put_contents(
                    public_path($cardPath),
                    file_get_contents($imageUrl)
                );
            }

            $special = null;
            if ($card['rarity'] === 'Promo') {
                $special = 'promo';
            }

            // save the card to the database
            Card::firstOrCreate([
                'card_no' => $card['number'],
                'set_id' => $activeSet->id,
                'special' => $special
            ],[
                'id' => Str::uuid(),
                'name' => $card['name'],
                'card_type' => $card['card_type'],
                'type' => $card['type'] ?: null,
                'rarity' => $card['rarity'] ?: null,
                'image' => $cardPath
            ]);

            if (isset($rarities[$card['rarity']]) && $rarities[$card['rarity']] <= 2) {
                dump('Adding holo version of the card...');
                // save the card as reverse holo
                Card::firstOrCreate([
                    'card_no' => $card['number'],
                    'set_id' => $activeSet->id,
                    'special' => 'holo'
                ],[
                    'id' => Str::uuid(),
                    'name' => $card['name'],
                    'card_type' => $card['card_type'],
                    'type' => $card['type'] ?: null,
                    'rarity' => $card['rarity'] ?: null,
                    'image' => $cardPath,
                ]);
            }

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

    public function getSetsUserHasCardsFor(): array
    {
        $user = auth()->user();
        $cards = (new UserCards)->with('card')->where('user_id', $user->uuid)->get();

        $sets = $cards->pluck('card.set_id')->unique();
        $sets = (new CardSet)->whereIn('id', $sets)->get();

        return $sets->toArray();
    }

    public function getCardsForUserBySet(string $setId)
    {
        $set = (new CardSet)->where('id', $setId)->firstOrFail();

        $user = auth()->user();

        $userCards = (new UserCards)
            ->with(['card' => fn($query) => $query->where('set_id', $set->id)])
            ->where('user_id', $user->uuid)
            ->get()
        ;

        // dd($userCards->toSQL());
        $setCards = (new Card)->where('set_id', $set->id)->get();

        $cards = $setCards->map(function($card) use($userCards) {
            $collected = $userCards->where('id', $card->id)->first();
            dump($collected);

            $card['collected'] = $collected !== null;

            return $card;
        });

        return [
            'set' => $set->toArray(),
            'info' => [
                'set_cards' => $setCards->count(),
                'collected' => $userCards->count(),
                'not_collected' => $setCards->count() - $userCards->count(),
            ],
            'cards' => $cards->where('collected', true)->toArray(),
        ];
    }

}
