<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cardset extends Model
{
    protected $table = 'sets';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = true;
    public $guarded = [];

    public function cards()
    {
        return $this->hasMany(Card::class, 'set_id', 'id')->orderBy(DB::RAW('`special`, `card_no`'));
    }
}