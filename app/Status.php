<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $fillable = ['name', 'color', 'is_active'];

    public function tasks(){
        return $this->hasMany('App\Task');
    }

    public function projects(){
        return $this->hasMany('App\Project');
    }

}
