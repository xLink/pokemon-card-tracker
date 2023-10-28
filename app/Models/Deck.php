<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deck extends Model
{
    protected $table = 'decks';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = true;
    public $guarded = [];
}