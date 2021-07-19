<?php

namespace App\Http\Controllers\Admin;

use App\Models\Blogs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BlogController extends Controller
{
    /**
     * Rendering blade file with values listing all blogs in the system
     *
     * @return blade file with array
     */
    public function show(Request $request)
    {
        $blogsQuery = Blogs::select(
            'title',
            'description',
            'blogs.id AS blogId',
            'first_name',
            'last_name',
            'email'
        )->join('users', 'users.id', '=', 'user_id');

        if ($request->search) {
            $blogsQuery->where(function ($query) use ($request) {
                $query->where('title', 'like', "%$request->search%")
                    ->orWhere('description', 'like', "%$request->search%");
            });
        }

        $blogs = $blogsQuery->paginate(20);

        return view('admin.blog-list', compact('blogs'));
    }
}