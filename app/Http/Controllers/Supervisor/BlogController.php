<?php

namespace App\Http\Controllers\Supervisor;

use App\Models\Blogs;
use App\Models\AssignedUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class BlogController extends Controller
{
    /**
     * Renders the blog list of Supervisor and Bloggers assigned to the Supervisor
     *
     * @return blade file with array
     */
    public function index(Request $request)
    {
        $bloggerId = AssignedUsers::where('supervisor_id', Auth::user()->id)
            ->get()->pluck('blogger_id')->toArray();

        $blogsQuery = Blogs::select(
            'blogs.id as blogId',
            'title',
            'description',
            'user_id',
            'first_name',
            'last_name',
            'email'
        )->join('users', 'users.id', '=', 'user_id')
        ->where(function ($query) use ($bloggerId) {
            $query->whereIn('user_id', $bloggerId)
                ->orWhere('user_id', Auth::user()->id);
        });

        if ($request->search) {
            $blogsQuery->where(function ($query) use ($request) {
                $query->where('title', 'like', "%$request->search%")
                    ->orWhere('description', 'like', "%$request->search%");
            });
        }

        $blogs = $blogsQuery->paginate(20);

        return view('supervisor.blog-list', compact('blogs'));
    }
}
