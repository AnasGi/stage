<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cm extends Model
{
    use HasFactory;

    protected $table='cm';

    protected $fillable =[
        'id',
        'clients_id',
        'date_depot',
        'num_depot',
        'montant',
        'motif',
    'annee',
    ];

    public function clients()
    {
        return $this->belongsTo(Client::class, 'clients_id'); // Specify the correct foreign key
    }
}
