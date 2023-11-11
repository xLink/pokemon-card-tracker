<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use \Staudenmeir\EloquentHasManyDeep\HasRelationships;

    protected $primaryKey = 'uuid';
    public $incrementing = false;

    protected $fillable = ['name','email','password'];
    protected $hidden = ['password','remember_token'];
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public $appends = ['id'];

    public function cards()
    {
        return $this->hasManyThrough(
            Card::class,
            UserCards::class,
            'user_id',              // foreign key on 2nd
            'id',                   // foreign key on 1st
            'uuid',                 // local key on Self
            'card_id'               // local key on 2nd
        );
    }

    public function sets()
    {
        return $this->hasManyDeep(
            Cardset::class,
            [UserCards::class, Card::class],
            [
                'user_id',              // foreign key on 2nd
                'id',                   // foreign key on 1st
                'id',                   // local key on Self
                'id'                    // local key on 2nd
            ],
            [
                'id',                   // foreign key on 3rd
                'card_id',              // foreign key on 2nd
                'set_id'                // local key on 3rd
            ]
        )->groupBy('sets.id');
    }

    public function getIdAttribute() {
        return $this->uuid;
    }
}
