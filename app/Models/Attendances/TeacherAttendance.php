<?php

namespace App\Models\Attendances;

use App\Models\Attendance\AttendanceStatus;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TeacherAttendance
 * @package App\Models\Attendances
 *
 * @property int $id
 * @property int $user_id
 * @property int $campus_id
 * @property int $attendance_status_id
 * @property string $date
 * @property string $comments
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @property AttendanceStatus $status

 */
class TeacherAttendance extends Model
{
    protected $table = 'teacher_attendances';

    protected $fillable = [
        'user_id',
        'campus_id',
        'attendance_status_id',
        'comments',
        'date',
    ];

    protected $hidden = [
        'user_id',
        'campus_id',
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
