<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;

    protected $table = 'client_collabs_history';


    protected $fillable = [
        'clients_id',
        'users_id',
    ];

    public function clients()
    {
        return $this->belongsTo(Client::class, 'clients_id'); 
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'users_id'); 
    }
}
