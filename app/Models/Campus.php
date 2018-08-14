<?php

namespace App\Models;

use App\Models\Attendances\TeacherAttendance;
use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Campus
 * @package App\Models
 *
 * @property int $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property int created_by
 * @property int school_id
 *
 * @property Grade[] $grades
 * @property User[] $users
 * @property Staff[] $staffs
 * @property Student[] $students
 * @property Teacher[] $teachers
 * @property Subject[] $subjects
 * @property Staff $creator
 *
 * @method static Campus find($id)
 */
class Campus extends Model
{
    protected $table = 'campuses';

    protected $fillable = [
        'name',
        'registration_number',
        'phone_number',
        'fax',
        'address',
        'city',
        'country',
    ];

    protected $hidden = [
        'created_by',
        'school_id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo | Staff
     */
    public function creator()
    {
        return $this->belongsTo(Staff::class, 'created_by');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany | User
     */
    public function users()
    {
        return $this->hasMany(User::class,  'campus_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany | Staff
     */
    public function staffs()
    {
        return $this->hasMany(Staff::class, 'campus_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany | Student
     */
    public function students()
    {
        return $this->hasMany(Student::class, 'campus_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany | Teacher
     */
    public function teachers()
    {
        return $this->hasMany(Teacher::class, 'campus_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany | Grade
     */
    public function grades()
    {
        return $this->hasMany(Grade::class, 'campus_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany | Subject
     */
    public function subjects()
    {
        return $this->hasMany(Subject::class,'campus_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany | TeacherAttendance
     */
    public function teacherAttendances()
    {
        return $this->hasMany(TeacherAttendance::class, 'campus_id');
    }
}
