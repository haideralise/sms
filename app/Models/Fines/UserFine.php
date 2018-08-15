<?php

namespace App\Models\Fines;

use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserFine
 * @package App\Models\Fines
 */
class UserFine extends Model
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function imposer()
    {
        return $this->belongsTo(User::class, 'fined_by');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Fined()
    {
        return $this->belongsTo(User::class, 'fined_to');
    }

}
