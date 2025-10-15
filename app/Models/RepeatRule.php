<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RepeatRule extends Model
{
    //trạng thái task lặp lại
    const STATUS_IN_PROGRESS = 0;
    const STATUS_DONE = 1;
    const STATUS_DELETING = 2;

    //độ ưu tiên task lặp lại
    const PRIORITY_LOW = 0;
    const PRIORITY_ADMIN = 1;

    //kiểu lặp lại repeat_type
    const REPEAT_TYPE_NONE = 0;
    const REPEAT_TYPE_DAILY = 1;
    const REPEAT_TYPE_DAY_OF_WEEK = 2;
    const REPEAT_TYPE_MONTHLY = 3;

    //option lặp lại
    const REPEAT_BY_INTERVAL = 1;
    const REPEAT_BY_DUE_DATE = 2;

    //due_date_select
    const TODAY = 1;
    const TOMORROW = 2;
    const WEEKEND = 3;
    const CUSTOM = 4;

    protected $fillable = [
        'task_id',
        'repeat_type',
        'repeat_interval',
        'repeat_due_date',
        'status_repeat_task',
        'priority_repeat_task'
    ];

    public function task(){
        return $this->belongsTo(Task::class, 'task_id', 'id');
    }
}
