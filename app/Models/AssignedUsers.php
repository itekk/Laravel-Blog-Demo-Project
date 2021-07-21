<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssignedUsers extends Model
{
    protected $table      = 'assigned_users';
    protected $primaryKey = 'id';
    public $timestamps    = false;
    protected $guarded    = [];

    public function getUser()
    {
        return $this->hasOne('App\User', 'id', 'blogger_id');
    }

    public function getBlogs()
    {
        return $this->hasMany('App\Models\Blogs', 'user_id', 'blogger_id');
    }
}
