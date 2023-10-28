<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\PkmnCardsService;
use function Laravel\Prompts\select;

class ImportSets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-sets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $setList = PkmnCardsService::getSetListing();

        // Prompt the user to select a set from the $setList array
        $setNames = $setList->pluck('name');
        $setIndex = select('Which set do you want to import?', $setNames);

        $selectedSet = $setList->where('name', $setIndex)->first();

        PkmnCardsService::importSet($selectedSet);
    }
}