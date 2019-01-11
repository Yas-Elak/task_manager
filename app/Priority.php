<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class priority extends Model
{
    protected $fillable = ['name', 'color', 'is_active'];
}
