<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCards extends Model
{
    protected $table = 'user_cards';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = true;
    public $guarded = [];

    public function card()
    {
        return $this->belongsTo(Card::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}