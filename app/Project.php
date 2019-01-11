<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['subject', 'description', 'is_active', 'manager_id', 'status_id', 'priority_id'];

    public function user(){
        return $this->belongsTo('App\User', 'manager_id');
    }

    public function tasks(){
        return $this->hasMany('App\Task');
    }

    public function users(){
        return $this->belongsToMany('App\User');
    }

    public function status()
    {
        return $this->belongsTo('App\Status');
    }

    public function priority()
    {
        return $this->belongsTo('App\Priority');
    }
    public function comments()
    {
        $this->hasMany('App\Comment', 'project_id');
    }


    public function audits()
    {
        return $this->hasMany('App\Audit');
    }

    /**
     *
     * Function to concatenate all the information of the projects and put it in the audit table
     * @param $project
     * @param $owner
     * @param null $state
     * @return Audit
     */
    public static function auditProjectOperation($project, $owner, $state=NULL){
        return new Audit([
            'operation' => $state . ' : Audit for project n° ' . $project->id . '/// Subject : ' . $project->subject .
                ' /// Description : ' . $project->description . ' /// Project_id : ' . $project->project_id .
                ' /// Status_id ' . $project->status_id . ' /// priority_id ' . $project->priority_id .
                ' /// is_active ' . $project->is_active . ' /// manager_id ' . $project->manager_id,
            'user_id' => $owner->id,
            'project_id' => $project->id
        ]);
    }

    /**
     *
     * to count the user's project and use in the charts
     * @param $table
     * @param $user
     * @param $state
     * @return mixed
     */
    public static function countUserProjectBy($table ,$user ,$state){
        return $user->projects()->whereHas($table, function($query) use ($state) {
            $query->where('name', '=', $state);
        })->get()->count();
    }

}
