<?php

namespace App\Http\Controllers\Blogger;

use App\Models\Blogs;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Renders blogger's personal details and blog details
     *
     * @return blade file with array
     */
    public function index()
    {
        $userDet   = Auth::user();
        $userBlogs = Blogs::where('user_id', Auth::user()->id)->get()->count();

        return view('blogger.index', compact('userDet', 'userBlogs'));
    }
}
