<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use \Znck\Eloquent\Traits\BelongsToThrough;

    protected $table = 'cards';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;
    public $guarded = [];

    public function set()
    {
        return $this->belongsTo(Cardset::class, 'set_id', 'id');
    }

    public function collected()
    {
        return $this->belongsToThrough(User::class, Cardset::class, 'id', 'set_id', 'id', 'set_id');
    }
}
