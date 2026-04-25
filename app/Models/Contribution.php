<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contribution extends Model
{
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