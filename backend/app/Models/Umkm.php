<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToClient;

class Umkm extends Model
{
    use HasFactory, BelongsToClient;

    protected $fillable = [
        'client_id',
        'user_id',
        'nama_usaha',
        'kategori',
        'deskripsi',
        'nomor_whatsapp',
        'is_active'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
