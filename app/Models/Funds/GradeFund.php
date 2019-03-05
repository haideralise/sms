<?php

namespace App\Models\Funds;

use App\Models\Grade;
use Illuminate\Database\Eloquent\Model;

class GradeFund extends Model
{

    protected $fillable = ['month', 'year', 'amount', 'is_active'];
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function grade()
    {
        return $this->belongsTo(Grade::class, 'grade_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function fundType()
    {
        return $this->belongsTo(FundType::class, 'fund_type_id');
    }
}
