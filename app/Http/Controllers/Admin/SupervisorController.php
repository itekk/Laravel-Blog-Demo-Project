<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Models\AssignedUsers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SupervisorController extends Controller
{
    /**
     * Rendering Supervisors list
     *
     * @return blade file with array
     */
    public function index(Request $request)
    {
        $userList = User::where('user_type', 'supervisor')
            ->paginate(20);
            
        return view('admin.supervisor-list', compact('userList'));
    }

    /**
     * Rendering Bloggers under a Supervisor
     *
     * @return blade file with array
     */
    public function listBloggers(Request $request)
    {
        $userList = AssignedUsers::where('supervisor_id', $request->route('id'))
            ->paginate(20);
            
        return view('admin.blogger-list', compact('userList'));
    }
}