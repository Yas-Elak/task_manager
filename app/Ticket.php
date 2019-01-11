<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'subject',
        'description',
        'task_id',
        'project_id',
        'status_id',
        'priority_id',
        'is_active',
        'agent_id',
        'owner_id'
    ];

    public function priority()
    {
        return $this->belongsTo('App\Priority');
    }

    public function status()
    {
        return $this->belongsTo('App\Status');
    }

    public function task()
    {
        return $this->belongsTo('App\Task');
    }

    public function project()
    {
        return $this->belongsTo('App\Project');
    }

    public function owner()
    {
        return $this->belongsTo('App\User');
    }
    public function agent()
    {
        return $this->belongsTo('App\User');
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
     * @param $ticket
     * @param $owner
     * @param null $state
     * @return Audit
     */
    public static function auditTicketOperation($ticket, $owner, $state=NULL){
        return new Audit([
            'operation' => $state . 'Audit for ticket n° ' . $ticket->id . '/// Subject : ' . $ticket->subject .
                ' /// Description : ' . $ticket->description . ' /// Project_id : ' . $ticket->project_id .
                ' /// Task_id ' . $ticket->task_id . ' /// Agent_id ' . $ticket->task_id .
                ' /// Status_id ' . $ticket->status_id . ' /// priority_id ' . $ticket->priority_id .
                ' /// Component_id ' . $ticket->component_id . ' /// Owner_id ' . $ticket->owner_id,
            'user_id' => $owner->id,
            'ticket_id' => $ticket->id
        ]);
    }
}
