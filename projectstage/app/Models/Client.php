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
        'collaborateur',
    ];

    // public function users(){
    //     return $this->belongsTo(related: User::class);
    // }

    public function tvam(){
        return $this->hasMany(related: Tvam::class);
    }
    
    public function tvat(){
        return $this->hasMany(related: Tvat::class);
    }
    
    public function cnss(){
        return $this->hasMany(related: Cnss::class);
    }
    
    public function ir(){
        return $this->hasMany(related: Ir::class);
    }
    
    public function droittimbers(){
        return $this->hasMany(related: Droittimber::class);
    }
    
    public function etats(){
        return $this->hasMany(related: Etat::class);
    }
    
    public function bilans(){
        return $this->hasMany(related: Bilan::class);
    }
    
    public function acomptes(){
        return $this->hasMany(related: Acompte::class);
    }
    
    public function cm(){
        return $this->hasMany(related: Cm::class);
    }
}
