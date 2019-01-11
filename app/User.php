<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'role_id', 'is_active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function role(){
        return $this->belongsTo('App\role');
    }
    public function tasks()
    {
        return $this->belongsToMany('App\Task');
    }

    public function completedTicketsAsOwner()
    {
        return $this->hasMany('App\Ticket', 'owner_id');
    }

    public function completedTicketsAsAgent()
    {
        return $this->hasMany('App\Ticket', 'agent_id');
    }

    public function assignedTickets()
    {
        return $this->hasMany('App\Ticket', 'agent_id');
    }
    public function createdTickets()
    {
        return $this->hasMany('App\Ticket', 'owner_id');
    }
    public function projects()
    {
        return $this->belongsToMany('App\Project');
    }

    public function audits()
    {
        return $this->hasMany('App\Audit');
    }

    public function option(){
        return $this->hasOne('App\Option');
    }

    public function notification(){
        return $this->hasMany('App\Notification');
    }


    /**
     * Check if the user is admin by getting his role in the table roles
     *
     * @return bool
     */
    public function isAdmin(){
        if($this->role->name == 'Administrator' && $this->is_active == 1){
            return true;
        }
        return false;
    }

    /**
     * Check if the user is admin by getting his role in the table roles
     * @return bool
     */
    public function isManager(){
        if($this->role->name == 'Manager' && $this->is_active == 1){
            return true;
        }
        return false;
    }


    //Accessors
    public function getNameEmailAttribute()
    {
        return $this->name . ' : ' . $this->email;
    }




}
