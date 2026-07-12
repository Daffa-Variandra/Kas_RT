<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\BelongsToClient;

class Family extends Model
{
    use HasFactory, BelongsToClient;

    protected $fillable = [
        'user_id',
        'no_kk',
        'alamat',
        'status_hunian',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function residents()
    {
        return $this->hasMany(Resident::class);
    }
}
