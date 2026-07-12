<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToClient;

class GuestLog extends Model
{
    use HasFactory, BelongsToClient;

    protected $fillable = [
        'client_id',
        'nama_tamu',
        'tujuan',
        'waktu_masuk',
        'waktu_keluar',
        'foto_identitas',
        'keterangan'
    ];

    protected $casts = [
        'waktu_masuk' => 'datetime',
        'waktu_keluar' => 'datetime',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
