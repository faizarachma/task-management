<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskStatus extends Model
{
    protected $fillable = [
        'name',
        'description',
        'color',
    ];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

}
