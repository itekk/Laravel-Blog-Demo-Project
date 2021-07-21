<?php

namespace App\Http\Controllers\Supervisor;

use App\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Blogs;

class DashboardController extends Controller
{
    /**
     * Renders the Supervisor's personal details and blog details of assigned bloggers
     *
     * @return blade file with array
     */
    public function index()
    {
        $userDet = User::find(Auth::user()->id);

        $blogers = $userDet->getBloggers()
            ->get()
            ->pluck('blogger_id')
            ->toArray();

        $totalBlogs = Blogs::whereIn('user_id', $blogers)
            ->get()->count();

        return view('supervisor.index', compact('userDet', 'totalBlogs'));
    }
}
