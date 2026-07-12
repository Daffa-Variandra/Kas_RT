<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\BelongsToClient;

class Expense extends Model
{
    use BelongsToClient;

    protected $fillable = [
        'client_id',
        'title',
        'category',
        'amount',
        'expense_date',
        'receipt_path',
        'notes',
    ];
}
