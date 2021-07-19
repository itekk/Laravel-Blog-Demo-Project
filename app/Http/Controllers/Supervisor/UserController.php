<?php

namespace App\Http\Controllers\Supervisor;

use App\User;
use App\Models\Blogs;
use App\Models\AssignedUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Rendering bloggers assigned to a supervisors
     *
     * @return blade file with array
     */
    public function index()
    {
        $userQuery = AssignedUsers::select(
            'users.id',
            'first_name',
            'last_name',
            'email',
            'user_type',
            'last_login',
            DB::raw('COUNT(blogs.id) AS numBlogs')
        )->join('users', 'users.id', '=', 'blogger_id')
        ->leftJoin('blogs', 'user_id', '=', 'blogger_id')
        ->where('supervisor_id', Auth::user()->id);

        $userList = $userQuery->groupBy('users.id')
            ->paginate(20);

        return view('supervisor.user-list', compact('userList'));
    }
}