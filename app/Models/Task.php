<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\TaskStatus;
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

    public function taskStatus()
    {
        return $this->belongsTo(TaskStatus::class);
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
