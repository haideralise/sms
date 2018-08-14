<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Subject
 * @package App\Models
 *
 * @property int $id
 * @property int campus_id
 *
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 *
 * @method static Subject find($id)
 */
class Subject extends Model
{
    use SoftDeletes;

    protected $table = 'subjects';

    protected $fillable = [
        'name',
        'code',
        'description',
    ];

    protected $hidden = [
        'campus_id',
        'deleted_at',
        'created_by',
        'pivot',
    ];
}
