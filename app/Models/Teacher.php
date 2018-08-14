<?php

namespace App\Models;

use App\Models\Attendances\TeacherAttendance;
use App\User;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class Teachers
 * @package App\Models
 *
 * @property TeacherAttendance[] $attendances
 * @property TeacherAttendance $attendance
 */
class Teacher extends User
{
    protected $table = 'users';

    protected $attributes = [
        'type' => self::TYPE_TEACHER,
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany | SectionAssignment
     */
    public function sectionAssignments()
    {
        return $this->hasMany(SectionAssignment::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany | User
     */
    public function sections()
    {
        return $this->belongsToMany(Section::class, 'section_assignments', 'user_id', 'section_id')
            ->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne | TeacherAttendance
     */
    public function attendance()
    {
        return $this->hasOne(TeacherAttendance::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany | TeacherAttendance
     */
    public function attendances()
    {
        return $this->hasMany(TeacherAttendance::class, 'user_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('type', function (Builder $builder) {

            $builder->where('type', self::TYPE_TEACHER);
        });
    }
}
