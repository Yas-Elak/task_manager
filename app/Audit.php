<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Audit extends Model
{
    protected $fillable = [
        'operation',
        'user_id',
        'ticket_id',
        'task_id',
        'project_id',
        'comment_id'
    ];

    public function ticket(){
        return $this->belongsTo('App\Ticket', 'ticket_id');
    }

    public function task(){
        return $this->belongsTo('App\Task', 'task_id');
    }

    public function project(){
        return $this->belongsTo('App\Project', 'project_id');
    }
}
