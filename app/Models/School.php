<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class School
 * @package App\Models
 *
 * @property int $id
 * @property int main_campus_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @property Campus[] $campuses
 * @property int created_by
 */
class School extends Model
{
    protected $table = 'schools';

    protected $fillable = [
        'name',
        'logo',
        'banner',
        'registration_number',
    ];

    protected $hidden = [
        'created_by',
        'main_campus_id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany | Campus
     */
    public function campuses()
    {
        return $this->hasMany(Campus::class, 'school_id');
    }
}
