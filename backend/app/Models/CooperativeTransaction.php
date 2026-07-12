<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToClient;

class CooperativeTransaction extends Model
{
    use HasFactory, BelongsToClient;

    protected $fillable = [
        'client_id',
        'user_id',
        'jenis_transaksi',
        'jumlah',
        'bukti_bayar',
        'keterangan',
        'status',
        'cooperative_loan_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function loan()
    {
        return $this->belongsTo(CooperativeLoan::class, 'cooperative_loan_id');
    }
}
