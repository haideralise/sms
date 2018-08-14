<?php

namespace App\Models;

use App\Models\Attendance\StudentAttendance;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Section
 * @package App\Models
 *
 * @property int $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 *
 * @property Grade $grade
 * @property Student[] $students
 *
 * @method static Section find($id)
 */
class Section extends Model
{
    use SoftDeletes;

    protected $table = 'sections';

    protected $fillable = [
        'name',
        'code',
        'description',
    ];

    protected $hidden = [
        'grade_id',
        'deleted_at',
        'created_by',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo | Grade
     */
    public function grade()
    {
        return $this->belongsTo(Grade::class, 'grade_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'section_subject', 'section_id', 'subject_id')
            ->withTimestamps();
    }

    public function assignedSubjects()
    {
        return $this->belongsToMany(Subject::class, 'section_assignments', 'section_id', 'subject_id')
            ->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany | Teacher
     */
    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'section_assignments', 'section_id', 'user_id')->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany | Student
     */
    public function students()
    {
        return $this->hasMany(Student::class, 'section_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany | StudentAttendance
     */
    public function studentAttendances()
    {
        return $this->hasMany(StudentAttendance::class, 'section_id');
    }
}
