<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Irprof extends Model
{
    use HasFactory;

    protected $table = 'irprof';

    protected $fillable =[
        'id',
        'clients_id',
        'date_depot',
        'num_depot',
        'motif',
    'annee',
    ];

    public function clients()
    {
        return $this->belongsTo(Client::class, 'clients_id'); // Specify the correct foreign key
    }
}
