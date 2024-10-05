<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cnss extends Model
{
    use HasFactory;

    protected $table = 'cnss';

    protected $fillable =[
        'id',
        'clients_id',
        'date_depot_1',
        'date_depot_2',
        'date_depot_3',
        'date_depot_4',
        'date_depot_5',
        'date_depot_6',
        'date_depot_7',
        'date_depot_8',
        'date_depot_9',
        'date_depot_10',
        'date_depot_11',
        'date_depot_12',
    'annee',
    ];

    public function clients(){
        return $this->belongsTo(related: Client::class);
    }
}
