<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToClient;

class AssetLoan extends Model
{
    use HasFactory, BelongsToClient;

    protected $fillable = [
        'client_id',
        'asset_id',
        'user_id',
        'tanggal_pinjam',
        'tanggal_kembali',
        'jumlah',
        'status',
        'keterangan'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
