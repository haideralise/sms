<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SectionAssignment
 * @package App\Models
 *
 * @property int $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @property Subject $subject
 * @property Section $section
 */
class SectionAssignment extends Model
{
    protected $table = 'section_assignments';

    protected $fillable = [
        'subject_id',
        'section_id',
        'user_id',
    ];

    protected $hidden = [
        'subject_id',
        'section_id',
        'user_id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo | Subject
     */
    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo | Section
     */
    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }
}
