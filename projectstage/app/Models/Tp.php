<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tp extends Model
{
    use HasFactory;

    protected $table = 'tp';

    protected $fillable =[
        'id',
        'clients_id',
        'date_depot',
        'num_depot',
    'annee',
    ];

    public function clients(){
        return $this->belongsTo(related: Client::class);
    }
}