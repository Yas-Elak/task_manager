<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $fillable = [
        'user_id',
        'project_notification',
        'project_email',
        'task_notification',
        'task_email',
        'ticket_notification',
        'ticket_email',
        'comment_notification',
        'comment_email'
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }
}
