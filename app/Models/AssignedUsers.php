<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssignedUsers extends Model
{
    protected $table      = 'assigned_users';
    protected $primaryKey = 'id';
    public $timestamps    = false;
    protected $guarded    = [];
}
