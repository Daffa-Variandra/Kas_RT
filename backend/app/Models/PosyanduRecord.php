<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToClient;

class PosyanduRecord extends Model
{
    use HasFactory, BelongsToClient;

    protected $fillable = [
        'client_id',
        'user_id',
        'nama_pasien',
        'kategori',
        'berat_badan',
        'tinggi_badan',
        'keterangan'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
