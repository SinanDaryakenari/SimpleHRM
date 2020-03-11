<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';

    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    public function role_user()
    {
        return $this->belongsTo('App\Models\RoleUser','id','role_id');
    }

}
