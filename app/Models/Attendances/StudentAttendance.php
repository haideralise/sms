<?php

namespace App\Models\Attendance;

use Illuminate\Database\Eloquent\Model;

/**
 * Class StudentAttendance
 * @package App\Models\Attendance
 *
 * @property int $id
 * @property int $user_id
 * @property int $section_id
 * @property int $attendance_status_id
 * @property string $date
 * @property string $comments
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @property AttendanceStatus $status
 */
class StudentAttendance extends Model
{
    protected $table = 'student_attendances';

    protected $fillable = [
        'user_id',
        'section_id',
        'attendance_status_id',
        'comments',
        'date',
    ];

    protected $hidden = [
        'user_id',
        'section_id',
        'attendance_status_id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo | AttendanceStatus
     */
    public function status()
    {
        return $this->belongsTo(AttendanceStatus::class, 'attendance_status_id');
    }
}
