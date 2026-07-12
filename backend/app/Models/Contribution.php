<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\BelongsToClient;

class Contribution extends Model
{
    use HasFactory, BelongsToClient;

    protected $fillable = [
        'nama_iuran',
        'nominal',
        'deskripsi'
    ];

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}