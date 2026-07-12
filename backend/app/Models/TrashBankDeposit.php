<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToClient;

class TrashBankDeposit extends Model
{
    use HasFactory, BelongsToClient;

    protected $fillable = [
        'client_id',
        'user_id',
        'jenis_sampah',
        'berat_kg',
        'nominal_rupiah',
        'keterangan',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
