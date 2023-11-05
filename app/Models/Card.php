<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $table = 'cards';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;
    public $guarded = [];

    public function set()
    {
        return $this->belongsTo(Cardset::class, 'set_id', 'id');
    }
}