<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable , SoftDeletes;

    protected $fillable = [
        'name',
        'password',
        'passwordText',
        'role',
        'active',
        'loggedout_at'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];


    public function clients(){
        return $this->hasMany(Client::class , 'users_id');
    }

    public function history()
    {
        return $this->hasMany(History::class, 'users_id'); 
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($user) {
            foreach ($user->clients as $client) {
                $client->cnss()->delete();
                $client->tvat()->delete();
                $client->tvam()->delete();
                $client->bilans()->delete();
                $client->cm()->delete();
                $client->ir()->delete();
                $client->acomptes()->delete();
                $client->irprof()->delete();
                $client->pv()->delete();
                $client->droittimbers()->delete();
                $client->etats()->delete();
                $client->tps()->delete();
            }
            $user->clients()->delete();
        });
    }
}
