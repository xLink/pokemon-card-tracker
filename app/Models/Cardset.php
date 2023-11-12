<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Cardset extends Model
{
    protected $table = 'sets';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = true;
    public $guarded = [];
    public $appends = ['logo', 'icon'];

    public function cards()
    {
        return $this->hasMany(Card::class, 'set_id', 'id')->orderBy(DB::RAW('`special`, `card_no`'));
    }

    protected function getLogoAttribute()
    {
        return sprintf('sets/%s/logo.png', $this->id);
    }

    protected function getIconAttribute()
    {
        return sprintf('sets/%s/icon.png', $this->id);
    }
}
