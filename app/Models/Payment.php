<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Contribution;

class Payment extends Model
{
    protected $fillable = [
        'user_id',
        'contribution_id',
        'jumlah_bayar',
        'tanggal_bayar',
        'bukti_bayar',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function contribution()
    {
        return $this->belongsTo(Contribution::class);
    }
}