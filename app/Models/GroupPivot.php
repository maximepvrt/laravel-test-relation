<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class GroupPivot extends Pivot
{
    const STATUS_PRE_REQUEST = 'pre-request';
    const STATUS_PENDING = 'pending';
    const STATUS_DENIED = 'denied';
    const STATUS_ACCEPTED = 'accepted';

    protected $casts = [
        'local_organization_data' => 'collection',
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($pivot) {
            error_log('saving event fire');
        });
    }
}
