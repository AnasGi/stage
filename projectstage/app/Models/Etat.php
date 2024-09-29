<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etat extends Model
{
    use HasFactory;


    protected $table = 'etat';
    protected $fillable =[
        'id',
        'clients_id',
        'date_depot',
        'num_depot',
    ];

    public function clients(){
        return $this->belongsTo(related: Client::class);
    }
}
