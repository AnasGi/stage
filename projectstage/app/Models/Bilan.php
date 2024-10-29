<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bilan extends Model
{
    use HasFactory;

    protected $table = 'bilan';

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
