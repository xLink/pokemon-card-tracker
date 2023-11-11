<?php

namespace App\Console\Commands;

use App\Models\Card;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use App\Models\Cardset;
use App\Models\UserCards;

class ImportScaryList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-scary-list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $tabs = [
        'SVI' => 0,
        'PAL' => 2021241623,
        'OBF' => 344995311,
        'MEW' => 30054247,
        'PAR' => 1629183217,
    ];


    /**
     * Execute the console command.
     */
    public function handle()
    {
        $set = $this->choice('Which set do you want to import from the spreadsheet?', array_keys($this->tabs), 0);
        $this->buildFile($set);

    }

    private function buildFile($set) 
    {
        $spreadsheet = 'https://docs.google.com/spreadsheets/d/18tmplwrAz9OSUmiB5pYsJ7u27e7wQ8GlYnQWWYHuJ_M/pub?gid=%d&single=true&output=csv'; // scarys source of truth
        // $spreadsheet = 'https://docs.google.com/spreadsheets/d/1Upgd8tpElwGuEFrYmg1VYA-Z0tubOhKM7_Myh-_ojXc/pub?gid=%d&single=true&output=csv'; // my copy
        $url = sprintf($spreadsheet, $this->tabs[$set]);
        
        $this->info('Looking for CardSet...');
        $cardSet = Cardset::find($set);
        $this->table(array_keys($cardSet->toArray()), [array_values($cardSet->toArray())]);
        
        $user = User::where('email', 'jadewilkins@live.co.uk')->firstOrFail();
        
        $keys = [];
        $newArray = [];
    
        // Do it
        $data = $this->csvToArray($url, ',');
    
        // Set number of elements (minus 1 because we shift off the first row)
        $count = count($data) - 6;
    
        //Use first row for names
        $keys = array_filter(array_slice($data, 5, 1)[0]);
   
        for ($i = 6; $i < $count; $i++) {
          $data[$i][] = $i;
        }
    
        // Bring it all together
        for ($j = 6; $j < $count; $j++) {
          $d = array_combine($keys, array_slice($data[$j], 0, count($keys)));
          $newArray[$j] = $d;
        }
    
        $this->info(sprintf('Found %d cards', count($newArray)));
        
        $newArray = collect($newArray)
            ->map(function($row) {
                $row['CardNo'] = str_pad($row['Set #'], 3, 0, STR_PAD_LEFT);
                $row['Main'] = $row['Main'] === '1' ? 1 : 0;
                $row['Reverse'] = $row['Reverse'] === '1' ? 1 : 0;
                unset($row['Set #']);

                return $row;
            })
            ->each(function($_card) use($cardSet, $user) {
                if ($_card['Main'] === 1) {
                    $card = Card::where('set_id', $cardSet->id)
                        ->where('card_no', $_card['CardNo'])
                        ->whereNull('special')
                        ->first();
                    if ($card === null) {
                        dd($_card);
                    }

                    $this->info('Adding '.$card->name.' to '.$user->name.'\'s collection');
                    UserCards::updateOrCreate([
                        'user_id' => $user->id,
                        'card_id' => $card->id,
                    ], [
                        'id' => Str::uuid()
                    ]);
                }
                if ($_card['Reverse'] === 1) {
                    $card = Card::where('set_id', $cardSet->id)
                        ->where('card_no', $_card['CardNo'])
                        ->where('special', 'holo')
                        ->first();
                    if ($card === null) {
                        dd($_card);
                    }


                    $this->info('Adding '.$card->name.'(reverse holo) to '.$user->name.'\'s collection');
                    UserCards::updateOrCreate([
                        'user_id' => $user->id,
                        'card_id' => $card->id,
                    ], [
                        'id' => Str::uuid()
                    ]);
                }
            })
        ;
    }

    // Function to convert CSV into associative array
    private function csvToArray($file, $delimiter)
    {
        $arr = [];
        if (($handle = fopen($file, 'r')) !== FALSE) {
            $i = 0;
            while (($lineArray = fgetcsv($handle, 4000, $delimiter, '"')) !== FALSE) {
                for ($j = 0; $j < count($lineArray); $j++) {
                    $arr[$i][$j] = $lineArray[$j];
                }
                $i++;
            }
            fclose($handle);
        }
        return $arr;
    }
}
