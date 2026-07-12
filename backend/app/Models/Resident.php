<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\BelongsToClient;

class Resident extends Model
{
    use HasFactory, BelongsToClient;

    protected $fillable = [
        'family_id',
        'nik',
        'nama',
        'no_hp',
        'status_keluarga'
    ];

    public function family()
    {
        return $this->belongsTo(Family::class);
    }
}