<?php

namespace App\Models;

use App\Models\Attendance\StudentAttendance;
use App\User;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class Student
 * @package App\Models
 *
 * @property Guardian $guardian
 * @property StudentAttendance[] $attendances
 * @property StudentAttendance $attendance
 */
class Student extends User
{
    protected $table = 'users';

    protected $attributes = [
        'type' => self::TYPE_STUDENT,
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo | Guardian
     */
    public function guardian()
    {
        return $this->belongsTo(Guardian::class, 'guardian_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('type', function (Builder $builder) {

            $builder->where('type', self::TYPE_STUDENT);
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany | StudentAttendance
     */
    public function attendances()
    {
        return $this->hasMany(StudentAttendance::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne | StudentAttendance
     */
    public function attendance()
    {
        return $this->hasOne(StudentAttendance::class, 'user_id');
    }
}
