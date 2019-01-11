<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'subject',
        'description',
        'status_id',
        'priority_id',
        'project_id',
        'owner_id',
        'wanted_start_datetime',
        'real_start_datetime',
        'wanted_end_datetime',
        'real_end_datetime'
    ];

    public function project()
    {
        return $this->belongsTo('App\Project');
    }

    public function priority()
    {
        return $this->belongsTo('App\Priority');
    }

    public function status()
    {
        return $this->belongsTo('App\Status');
    }

    public function issue()
    {
        return $this->belongsTo('App\Issue');
    }

    public function component()
    {
        return $this->belongsTo('App\Component');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment', 'task_id');
    }

    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    public function manager()
    {
        return $this->belongsTo('App\User','owner_id');
    }

    public function audits()
    {
        return $this->hasMany('App\Audit');
    }

    /**
     * Function to concatenate all the information of the projects and put it in the audit table
     * @param $task
     * @param $owner
     * @param null $state
     * @return Audit
     */
    public static function auditTaskOperation($task, $owner, $state=NULL){
        return new Audit([
            'operation' => $state . ' : Audit for task n° ' . $task->id . '/// Subject : ' . $task->subject .
                ' /// Description : ' . $task->description . ' /// Project_id : ' . $task->project_id .
                ' /// Status_id ' . $task->status_id . ' /// priority_id ' . $task->priority_id .
                ' /// Wanted start datetime ' . $task->wanted_start_datetime . ' /// real start date time ' . $task->real_start_datetime .
                ' /// Wanted end datetime ' . $task->wanted_end_datetime . ' /// real end date time ' . $task->real_end_datetime .
                ' /// is_active ' . $task->is_active . ' /// Owner_id ' . $task->owner_id,
            'user_id' => $owner->id,
            'task_id' => $task->id
        ]);
    }

    public static function countUserTaskBy($table, $user ,$state){
       return $user->tasks()->whereHas($table, function($query) use ($state) {
            $query->where('name', '=', $state);
        })->get()->count();
    }

    /**
     * Even if the field is Date in the datatable, when I get it, I get a string. So I have thses function
     * to parse it. Now I can use operation on it like < or >
     * @param $date
     * @return Carbon
     */
    public function getWantedEndDatetimeAttribute($date)
    {
        return Carbon::parse($date);
    }
    public function getWantedStartDatetimeAttribute($date)
    {
        return Carbon::parse($date);
    }
    public function getRealEndDatetimeAttribute($date)
    {
        if($date === Null){

        }else{
            return Carbon::parse($date);
        }
    }
    public function getRealStartDatetimeAttribute($date)
    {
        if($date === Null){

        }else {
            return Carbon::parse($date);
        }
    }
}
