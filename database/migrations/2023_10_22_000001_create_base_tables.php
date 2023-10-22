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
            $table->uuid();
            $table->string('name');
            $table->string('card_no', 3);
        });

        Schema::create('sets', function (Blueprint $table) {
            $table->uuid();
            $table->string('name');
            $table->string('abbreviation');
            $table->timestamps();
        });

        Schema::create('set_cards', function (Blueprint $table) {
            $table->uuid('set_id');
            $table->uuid('card_id');
        });

        Schema::create('decks', function (Blueprint $table) {
            $table->uuid();
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
