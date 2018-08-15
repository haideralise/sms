<?php

namespace App\Models\Fines;

use Illuminate\Database\Eloquent\Model;

class FineType extends Model
{
    protected $fillable = ['type', 'description'];
}
