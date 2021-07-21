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
        $blogsQuery = Blogs::orderByDesc('updated_at');

        if ($request->search) {
            $blogsQuery->whereRaw('title like ? or description like ?', [
                "%{$request->search}%",
                "%{$request->search}%"
            ]);
        }

        $blogs = $blogsQuery->paginate(20);

        return view('admin.blog-list', compact('blogs'));
    }
}