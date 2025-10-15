<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskDetail extends Model
{
    const STATUS_IN_PROGRESS = 0;
    const STATUS_DONE = 1;
    const STATUS_DELETING = 2;

    const PRIORITY_LOW = 0;
    const PRIORITY_ADMIN = 1;

    protected $fillable = [
        'task_id',
        'title',
        'description',
        'due_date',
        'time',
        'status',
        'priority',
        'parent_id'
    ];

    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id', 'id');
    }

    public function parent(){
        return $this->belongsTo(TaskDetail::class, 'parent_id', 'id');
    }

    public function children()
    {
        return $this->hasOne(TaskDetail::class, 'parent_id', 'id'); //select where parent_id = $task_id
    }


}
