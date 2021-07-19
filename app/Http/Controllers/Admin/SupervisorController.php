<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Models\Blogs;
use App\Models\AssignedUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class SupervisorController extends Controller
{
    /**
     * Rendering Supervisors list
     *
     * @return blade file with array
     */
    public function index(Request $request)
    {
        $userQuery = User::select(
            'users.id',
            'first_name',
            'last_name',
            'email',
            'last_login',
            DB::raw('COUNT(user_id) AS numBlogs'),
            DB::raw('COUNT(blogger_id) AS numBlogers')
        )->leftJoin('blogs', 'users.id', '=', 'user_id')
        ->leftJoin('assigned_users', 'users.id', '=', 'supervisor_id')
        ->where('user_type', 'supervisor');

        $userList = $userQuery->groupBy('users.id')
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
        $userQuery = AssignedUsers::select(
            'users.id',
            'first_name',
            'last_name',
            'email',
            'last_login',
            DB::raw('COUNT(user_id) AS numBlogs')
        )->join('users', 'users.id', '=', 'blogger_id')
        ->leftJoin('blogs', 'users.id', '=', 'user_id')
        ->where('supervisor_id', $request->id);

        $userList = $userQuery->groupBy('users.id')
            ->paginate(20);
            
        return view('admin.blogger-list', compact('userList'));
    }
}