<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToClient;

class CooperativeLoan extends Model
{
    use HasFactory, BelongsToClient;

    protected $fillable = [
        'client_id',
        'user_id',
        'pokok_pinjaman',
        'tenor_bulan',
        'skema',
        'margin_persen',
        'total_pinjaman',
        'angsuran_per_bulan',
        'sisa_pinjaman',
        'angsuran_ke',
        'keterangan',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
