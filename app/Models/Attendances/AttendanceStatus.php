<?php

namespace App\Models\Attendance;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AttendanceStatus
 * @package App\Models\Attendance
 *
 * @property int $id
 * @property string $title
 * @property string description
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class AttendanceStatus extends Model
{
    protected $table = 'attendance_statuses';

    const availableStatus = [
        1 => 'Present',
        2 => 'Absent',
        3 => 'Late',
        4 => 'Sick',
    ];

    protected $fillable = [
        'id',
        'title',
        'description',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
