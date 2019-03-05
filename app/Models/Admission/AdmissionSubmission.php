<?php

namespace App\Models\Admission;

use App\Models\Grade;
use App\PaymentStatus;
use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Class AdmissionSubmission
 * @package App\Models\Admission
 */
class AdmissionSubmission extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['submitted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
     return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function GradeAdmissionFee()
    {
        return $this->belongsTo(GradeAdmissionFee::class, 'grade_admission_fee_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function paymentStatus()
    {
        return $this->belongsTo(PaymentStatus::class, 'payment_status_id');
    }

}
