<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Severity extends Model
{
    protected $fillable = [
        'name',
        'description',
        'color',
        'priority',
    ];

}
