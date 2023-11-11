<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->string('name');
            $table->string('card_no', 3);
            $table->string('image')->nullable()->default(null);
            $table->enum('rarity', ['Common','Uncommon','Rare','Double Rare','Ultra Rare','Illustration Rare','Special Illustration Rare','Hyper Rare','Promo'])->nullable()->default(null);
            $table->enum('type', ['Fire', 'Water', 'Grass', 'Lightning', 'Psychic', 'Fighting', 'Darkness', 'Metal', 'Fairy', 'Dragon', 'Colorless'])->nullable()->default(null);
            $table->string('card_type');
            $table->string('special')->nullable()->default(null);
            $table->uuid('set_id');
            
        });

        Schema::create('sets', function (Blueprint $table) {
            $table->string('id', 5)->primary()->unique();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('decks', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('deck_cards', function (Blueprint $table) {
            $table->uuid('deck_id');
            $table->uuid('card_id');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cards');
        Schema::dropIfExists('sets');
        Schema::dropIfExists('set_cards');
        Schema::dropIfExists('decks');
        Schema::dropIfExists('deck_cards');
    }
};
