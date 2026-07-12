<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'name',
        'code',
        'address',
        'is_active',
        'is_auto_billing_enabled',
        'is_email_notification_active',
        'signature_path',
        'koperasi_skema',
        'koperasi_margin_persen',
    ];
}
