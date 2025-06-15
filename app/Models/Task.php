<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\TaskStatuse;
use App\Models\Severity;
use App\Models\User;

class Task extends Model
{
    protected $fillable = [
        'title',
        'description',
        'task_status_id',
        'severity_id',
        'user_id',
    ];

    public function taskStatuse()
    {
        return $this->belongsTo(TaskStatuse::class);
    }
    public function severity()
    {
        return $this->belongsTo(Severity::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
