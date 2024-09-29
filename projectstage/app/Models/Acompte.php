<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Acompte extends Model
{
    use HasFactory;

    protected $table = 'acompte';

    protected $fillable =[
        'id',
        'clients_id',
        'date_depot_0',
        'num_depot_0',
        'date_depot_1',
        'num_depot_1',
        'date_depot_2',
        'num_depot_2',
        'date_depot_3',
        'num_depot_3',
        'date_depot_4',
        'num_depot_4'
    ];

    public function clients(){
        return $this->belongsTo(related: Client::class);
    }
}
