<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class Guardian
 * @package App\Models
 *
 *
 * @property Student[] $students
 */
class Guardian extends User
{
    protected $table = 'users';

    protected $attributes = [
        'type' => self::TYPE_GUARDIAN,
    ];

    protected $hidden = [
        'email',
        'username',
        'agree_amount',
        'password',
        'created_by',
        'guardian_id',
        'campus_id',
        'section_id',
        'pivot',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany | Student
     */
    public function students()
    {
        return $this->hasMany(Student::class, 'guardian_id');
    }


    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('type', function (Builder $builder) {

            $builder->where('type', self::TYPE_GUARDIAN);
        });
    }
}
