<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToClient;

class SecuritySchedule extends Model
{
    use HasFactory, BelongsToClient;

    protected $fillable = [
        'client_id',
        'hari',
        'petugas',
        'keterangan'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
