<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

    protected $fillable = [
        'body',
        'moderate',
        'user_id',
        'task_id',
        'project_id',
        'ticket_id'
    ];

    public function task(){
        return $this->belongsTo('App\Task');
    }

    public function project(){
        return $this->belongsTo('App\Project' ,'project_id');
    }

    public function ticket(){
        return $this->belongsTo('App\Ticket');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }
}
