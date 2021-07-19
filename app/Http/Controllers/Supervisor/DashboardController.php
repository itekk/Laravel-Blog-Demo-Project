<?php

namespace App\Http\Controllers\Supervisor;

use App\User;
use App\Models\AssignedUsers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Renders the Supervisor's personal details and blog details of assigned bloggers
     *
     * @return blade file with array
     */
    public function index()
    {
        $userDet   = User::select(
            'first_name',
            'last_name',
            'email',
            'last_login',
            DB::raw('COUNT(user_id) AS numBlogs')
        )->leftJoin('blogs', 'users.id', '=', 'user_id')
        ->where('users.id', Auth::user()->id)
        ->groupBy('users.id')
        ->first();

        $totalBloggers = AssignedUsers::select(
            DB::raw('COUNT(blogger_id) AS totalBloggers')
        )->where('supervisor_id', Auth::user()->id)
        ->first();

        $totalBlogs = AssignedUsers::select(
            DB::raw('COUNT(blogs.id) AS totalBlogs')
        )->leftJoin('blogs', 'blogger_id', '=', 'user_id')
        ->where('supervisor_id', Auth::user()->id)
        ->first();

        return view('supervisor.index', compact('userDet', 'totalBloggers', 'totalBlogs'));
    }
}
