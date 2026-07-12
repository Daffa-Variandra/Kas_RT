<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\BelongsToClient;

class Complaint extends Model
{
    use BelongsToClient;

    protected $fillable = [
        'client_id',
        'user_id',
        'title',
        'description',
        'photo_path',
        'status',
        'admin_response',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
