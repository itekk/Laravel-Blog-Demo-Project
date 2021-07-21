<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Models\Blogs;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Rendering blade file with values listing user details and blog details
     *
     * @return blade file with array
     */
    public function index()
    {
        $userDet         = Auth::user();
        $totalBlogs      = Blogs::get()->count();
        $totalAdmin      = User::where('user_type', 'admin')->get()->count();
        $totalBlogger    = User::where('user_type', 'blogger')->get()->count();
        $totalSupervisor = User::where('user_type', 'supervisor')->get()->count();

        return view('admin.index', compact(
            'userDet',
            'totalBlogs',
            'totalAdmin',
            'totalBlogger',
            'totalSupervisor'
        ));
    }
}