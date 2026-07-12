<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait BelongsToClient
{
    public static function bootBelongsToClient()
    {
        static::addGlobalScope('client', function (Builder $builder) {
            // Apply scope only if user is logged in, has a client_id, and is NOT a superadmin
            // Use hasUser() instead of check() to avoid infinite loop when retrieving User from session
            if (auth()->hasUser() && auth()->user()->role !== 'superadmin' && auth()->user()->client_id) {
                $builder->where($builder->getModel()->getTable() . '.client_id', auth()->user()->client_id);
            }
        });

        static::creating(function ($model) {
            // Automatically assign client_id when creating a new record
            if (auth()->hasUser() && auth()->user()->role !== 'superadmin' && auth()->user()->client_id && !$model->client_id) {
                $model->client_id = auth()->user()->client_id;
            }
        });
    }

    public function client()
    {
        return $this->belongsTo(\App\Models\Client::class);
    }
}
