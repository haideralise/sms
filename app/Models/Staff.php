<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class Staff
 * @package App\Models
 *
 * @property int $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */

class Staff extends User
{
    protected $table = 'users';

    protected $attributes = [
        'type' => self::TYPE_STAFF,
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('type', function (Builder $builder) {

            $builder->where('type', self::TYPE_STAFF);
        });
    }
}
