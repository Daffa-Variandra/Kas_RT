<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Resident extends Model
{
   
    protected $fillable = [
        'user_id',
        'nik',
        'no_hp',
        'alamat',
        'status_hunian'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}