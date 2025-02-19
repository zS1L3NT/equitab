<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    public $timestamps = null;
    protected $primaryKey = 'code';
    public $incrementing = false;
    protected $keyType = 'string';
}
