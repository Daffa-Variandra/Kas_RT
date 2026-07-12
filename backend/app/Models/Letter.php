<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\BelongsToClient;

class Letter extends Model
{
    use BelongsToClient;

    protected $fillable = [
        'client_id',
        'user_id',
        'letter_type',
        'purpose',
        'reference_number',
        'status',
        'admin_notes',
        'pdf_path',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
