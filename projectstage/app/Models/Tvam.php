<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tvam extends Model
{
    use HasFactory;

    protected $table = 'tvam';

    protected $fillable =[
        'id',
        'clients_id',
        'date_depot_1',
        'num_depot_1',
        'date_depot_2',
        'num_depot_2',
        'date_depot_3',
        'num_depot_3',
        'date_depot_4',
        'num_depot_4',
        'date_depot_5',
        'num_depot_5',
        'date_depot_6',
        'num_depot_6',
        'date_depot_7',
        'num_depot_7',
        'date_depot_8',
        'num_depot_8',
        'date_depot_9',
        'num_depot_9',
        'date_depot_10',
        'num_depot_10',
        'date_depot_11',
        'num_depot_11',
        'date_depot_12',
        'num_depot_12',
        'motif_1',
        'motif_2',
        'motif_3',
        'motif_4',
        'motif_5',
        'motif_6',
        'motif_7',
        'motif_8',
        'motif_9',
        'motif_10',
        'motif_11',
        'motif_12',
    'annee',
    ];

    public function clients()
    {
        return $this->belongsTo(Client::class, 'clients_id'); // Specify the correct foreign key
    }
}
