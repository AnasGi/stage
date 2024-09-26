<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ir extends Model
{
    use HasFactory;

    protected $fillable =[
        'id',
        'clients_id',
        'mois',
        'date_depot',
        'num_depot',
    ];

    public function clients(){
        return $this->belongsTo(related: Client::class);
    }
}
