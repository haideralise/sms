<?php

namespace App\Models\Funds;

use Illuminate\Database\Eloquent\Model;

class FundType extends Model
{
    protected $fillable = ['type', 'description', 'is_active'];
}
