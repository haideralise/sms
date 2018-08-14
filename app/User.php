<?php

namespace App;

use App\Models\Campus;
use App\Models\Guardian;
use App\Models\School;
use App\Models\Section;
use App\Models\SectionAssignment;
use App\Models\Subject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User
 * @package App
 *
 * @property int $id
 * @property int created_by
 * @property int guardian_id
 * @property int campus_id
 * @property int section_id
 *
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @property School[] $schools
 * @property Section $section
 * @property Section[] $sections
 *
 * @method $this searchOnFields(array $fields, string $query)
 */
class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';

    const TYPE_STUDENT = 0;
    const TYPE_STAFF = 2;
    const TYPE_TEACHER = 1;
    const TYPE_GUARDIAN = 3;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'phone_number',
        'username',
        'email',
        'password',
        'national_id',
        'dob',
        'gender',
        'profile_picture',
        'address',
        'city',
        'country',
        'type',
        'agree_amount',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'created_by',
        'guardian_id',
        'campus_id',
        'section_id',
        'pivot',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany | School
     */
    public function schools()
    {
        return $this->hasMany(School::class, 'created_by');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo | Section
     */
    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany | Subject
     */
    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'section_assignments', 'user_id', 'subject_id')
            ->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany | SectionAssignment
     */
    public function sectionAssignments()
    {
        return $this->hasMany(SectionAssignment::class, 'user_id');
    }

    /**
     * scope for filtering user based on query string.
     *
     * @param $query
     * @param $fields array
     * @param $query_string
     *
     * @return mixed
     */
    public function scopeSearchOnFields($query, $fields ,$query_string)
    {
        if(is_array($fields) && count($fields) > 0 && !empty($query_string)) {
            $i = 0;
            foreach ($fields as $field) {
                if ($i == 0) {
                    $i = 1;
                    $query->where($field, 'like', $query_string.'%');
                } else {
                    $query->orWhere($field, 'like', $query_string.'%');
                }
            }
        }

        return $query;
    }

    /**
     * @param $query
     * @param Section $section
     * @return User
     */
    public function scopeOfSection($query, $section)
    {
        if (empty($section)) {
            return $query;
        }

        $section_id = $section instanceof Section ? $section->id : $section;

        return $query->where('users.section_id', $section_id);
    }

    /**
     * @param $query
     * @param Campus $campus
     * @return User
     */
    public function scopeOfCampus($query, $campus)
    {
        if (empty($campus)) {
            return $query;
        }

        $section_id = $campus instanceof Campus ? $campus->id : $campus;

        return $query->where('users.campus_id', $section_id);
    }

    /**
     * @param $query
     * @param Guardian $guardian
     * @return mixed
     */
    public function scopeOfGuardian($query, $guardian)
    {
        if (empty($guardian)) {
            return $query;
        }

        $section_id = $guardian instanceof Guardian ? $guardian->id : $guardian;

        return $query->where('users.guardian_id', $section_id);
    }

    /**
     * @param Campus $campus
     * @return $this
     */
    public function setCampus(Campus $campus)
    {
        $this->campus_id = $campus->id;

        return $this;
    }

    /**
     * @param Section $section
     * @return $this
     */
    public function setSection(Section $section)
    {
        $this->section_id = $section->id;

        return $this;
    }
}
