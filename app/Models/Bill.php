<?php

namespace App\Models;

use App\Sale;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $fillable = ['discount'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function forUser()
    {
        return $this->belongsTo(User::class, 'for_user');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function sales()
    {
        return $this->belongsToMany(Sale::class, 'bill_sales', 'bill_id', 'sale_id');
    }

}
