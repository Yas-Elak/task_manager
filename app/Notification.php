<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Notification extends Model
{
    protected $fillable = [
      'user_id',
      'project_id',
      'task_id',
      'ticket_id',
      'comment_id',
      'type'
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function project(){
        return $this->belongsTo('App\Project');
    }

    public function task(){
        return $this->belongsTo('App\Task');
    }

    public function ticket(){
        return $this->belongsTo('App\Ticket');
    }

    public function comment(){
        return $this->belongsTo('App\Comment');
    }

    /**
     *We take care of the condition for the notification to be display in NotificationsComposer.php
     * We still create the notification but only display them if the user wants Like that if if change is mind, we still
     * can display old notification
     */

}
