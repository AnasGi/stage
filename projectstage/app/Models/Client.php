<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory;

    use SoftDeletes;
    
    // Specify the deleted_at column
    protected $dates = ['deleted_at'];

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
        'ville',
        'users_id',
        'deletetype',
        'motif',
        'motifdoc',
        'newCltMotif'
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

    public function history()
    {
        return $this->hasMany(History::class, 'clients_id'); 
    }
    

    protected static function booted()
    {
        static::updating(function ($client) {
            if ($client->isDirty('users_id')) {
                // Get the original data before the update
                $originalData = $client->getOriginal();
    
                // Log old data, saving it to client_collabs_history
                DB::table('client_collabs_history')->insert([
                    'clients_id' => $originalData['id'],
                    'users_id' => $originalData['users_id'],
                    'updated_at' => now(),
                ]);
            }
        });
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
            $client->history()->delete();
        });
    }
}
