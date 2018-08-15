<?php

namespace App\Models\Admission;

use App\Models\Grade;
use Illuminate\Database\Eloquent\Model;

class GradeAdmissionFee extends Model
{
    protected $fillable = ['amount', 'applied_from'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }
}
