<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToClient;

class Cooperative extends Model
{
    use HasFactory, BelongsToClient;

    protected $fillable = [
        'client_id',
        'user_id',
        'saldo_simpanan',
        'saldo_pinjaman',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
