<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToClient;

class Asset extends Model
{
    use HasFactory, BelongsToClient;

    protected $fillable = [
        'client_id',
        'nama_barang',
        'kategori',
        'kondisi',
        'jumlah',
        'keterangan'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function loans()
    {
        return $this->hasMany(AssetLoan::class);
    }
}
