<?php

namespace App\Models;

use App\Models\Funds\GradeFund;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Grade
 * @package App\Models
 *
 * @property int $id
 * @property int $created_by
 * @property int campus_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 *
 * @property Section[] $sections
 * @property Campus $campus
 *
 * @method $this firstOrNew(array $info)
 */
class Grade extends Model
{
    use SoftDeletes;

    protected $table = 'grades';

    protected $fillable = [
        'name',
        'code',
        'fee',
        'description',
    ];

    protected $hidden = [
        'campus_id',
        'deleted_at',
        'created_by',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany | Grade
     */
    public function sections()
    {
        return $this->hasMany(Section::class, 'grade_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo | Campus
     */
    public function campus()
    {
        return $this->belongsTo(Campus::class, 'campus_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function funds()
    {
        return $this->hasMany(GradeFund::class, 'grade_id');
    }

}
