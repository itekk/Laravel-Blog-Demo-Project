<?php

namespace App\Http\Controllers\Blogger;

use App\Models\Blogs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class BlogController extends Controller
{
    /**
     * listing blogs that are added by the blogger
     *
     * @return blade file with array
     */
    public function show(Request $request)
    {
        $blogsQuery = Blogs::where('user_id', Auth::user()->id);

        if ($request->search) {
            $blogsQuery->where(function ($query) use ($request) {
                $query->whereRaw('title like ? or description like ?', [
                    "%{$request->search}%",
                    "%{$request->search}%"
                ]);
            });
        }

        $blogs = $blogsQuery->paginate(20);

        return view('blogger.list', compact('blogs'));
    }
}
