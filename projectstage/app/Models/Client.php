<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'code',
        'nom',
        'status',
        'adresse',
        'IF',
        'TP',
        'ICE',
        'CNSS',
        'RC',
        'debut_activite',
        'activite',
        'users_id',
    ];

    public function users()
    {
        return $this->belongsTo(User::class); 
    }

    public function tvam()
    {
        return $this->hasMany(Tvam::class, 'clients_id'); 
    }

    public function tvat()
    {
        return $this->hasMany(Tvat::class, 'clients_id'); 
    }

    public function cnss()
    {
        return $this->hasMany(Cnss::class, 'clients_id'); 
    }

    public function ir()
    {
        return $this->hasMany(Ir::class, 'clients_id'); 
    }

    public function droittimbers()
    {
        return $this->hasMany(Droittimber::class, 'clients_id'); 
    }

    public function etats()
    {
        return $this->hasMany(Etat::class, 'clients_id'); 
    }

    public function tps()
    {
        return $this->hasMany(Tp::class, 'clients_id'); 
    }

    public function bilans()
    {
        return $this->hasMany(Bilan::class, 'clients_id'); 
    }

    public function acomptes()
    {
        return $this->hasMany(Acompte::class, 'clients_id'); 
    }

    public function cm()
    {
        return $this->hasMany(Cm::class, 'clients_id'); 
    }

    public function pv()
    {
        return $this->hasMany(Cm::class, 'clients_id'); 
    }

    public function irprof()
    {
        return $this->hasMany(Irprof::class, 'clients_id'); 
    }


    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($client) {
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
        });
    }
}
