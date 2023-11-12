<?php

namespace App\Services;

use App\Models\Card;
use App\Models\Cardset;
use App\Models\User;
use App\Models\UserCards;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Weidner\Goutte\GoutteFacade as Goutte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function getSetsUserHasCardsFor(User $user): array
    {
        $cards = (new UserCards)->with('card')->where('user_id', $user->uuid)->get();

        $sets = $cards->pluck('card.set_id')->unique();
        $sets = (new CardSet)->whereIn('id', $sets)->get();

        return $sets->toArray();
    }

    public function getCardsForUserBySet(CardSet $set, User|null $user): Collection
    {
        $cards = \DB::table('cards')
            ->select('cards.*')
            ->selectRAW('true as active')

            ->when(
                auth()->user(), 
                function($query) use($user) {
                    $query->addSelect(
                        \DB::raw(
                            'EXISTS(SELECT 1 FROM user_cards WHERE user_cards.card_id = cards.id AND user_cards.user_id = "' . $user->id . '") as collected'
                        )
                    );
                }, 
                function ($query) {
                    $query->selectRAW('0 as collected');
                }
            )
            ->where('cards.set_id', $set->id)
            ->orderBy(DB::RAW('cards.special, cards.card_no'))
            ->get()
        ;

        return $cards;
    }

    public function makeCardsActive(Collection $cardList, Request $request): Collection
    {
        if (!$request->has('active')) {
            return $cardList;
        }

        $cardList = $cardList->when(
            $request->get($request->get('active'), false) !== false, 
            function($cardList) use ($request) {
                return $cardList->map(function($card) use ($request) {
                    $active = $request->get('active', null);
                    $property = strtolower($request->get($active, null));
                    $card_property = strtolower($card->$active);

                    $card->active = $property === $card_property;
                    return $card;
                });
            }
        );

        return $cardList;
    }

    public function makeCardsDivisibleBy(Collection $cardList, $cardsPerPage = 9): Collection 
    {
        $cardCount = $cardList->count();

        // make sure there are enough 'cards' to fill the pagination
        if ($cardCount % $cardsPerPage === 0) {
            return $cardList;
        }

        while($cardCount % $cardsPerPage !== 0) {
            $card = new Card;
            $card->name = 'Card Not Found';
            $card->image = 'sets/tcg-card-back.jpg';
            $card->card_no = null;
            $card->type = null;
            $card->special = null;
            $card->active = false;
            $cardList->push($card->toArray());

            $cardCount = $cardList->count();
        }

        return $cardList;
    }

    public function toggleCollectedForCards(Card $card, User $user): Collection
    {
        $userCard = UserCards::with('card.set')->where('user_id', $user->id)->where('card_id', $card->id)->first();

        if ($userCard) {
            $userCard->delete();
        } else {
            UserCards::create([
                'id' => Str::uuid(),
                'user_id' => $user->id,
                'card_id' => $card->id,
            ]);
        }

        return $this->getCardsForUserBySet($card->set, $user);
    }
}
