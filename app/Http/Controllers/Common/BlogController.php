<?php

namespace App\Http\Controllers\Common;

use App\Models\Blogs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class BlogController extends Controller
{
    /**
     * Rendering blog creating layout
     *
     * @return blade file
     */
    public function index()
    {
        return view('common.add');
    }

    /**
     * Saving a blog
     *
     * @return redirect to blog list page
     */
    public function store(Request $request)
    {
        $this->validate(request(), [
            'title'         => 'required|string|max:255',
            'description'   => 'required',
        ]);

        $blogs              = new Blogs;
        $blogs->title       = $request->title;
        $blogs->description = $request->description;
        $blogs->user_id     = Auth::user()->id;
        $blogs->created_at  = date('Y-m-d h:i:s');
        $blogs->save();

        return redirect(Auth::user()->user_type . '/blog-list');
    }

    /**
     * Rendering blog update layout with values
     *
     * @return blade file with array
     */
    public function update(Request $request)
    {
        $blogDet = Blogs::find($request->route('id'));

        return view('common.edit', compact('blogDet'));
    }

    /**
     * Updating a blog
     *
     * @return redirect to blog list page
     */
    public function updatePost(Request $request)
    {
        $this->validate(request(), [
            'title'         => 'required|string|max:255',
            'description'   => 'required',
        ]);

        $blogs              = Blogs::find($request->route('id'));
        $blogs->title       = $request->title;
        $blogs->description = $request->description;
        $blogs->updated_at  = date('Y-m-d h:i:s');
        $blogs->save();

        return redirect(Auth::user()->user_type . '/blog-list');
    }

    /**
     * Deleting a blog
     *
     * @return null
     */
    public function delete(Request $request)
    {
        $blogs = Blogs::find($request->route('id'));
        $blogs->delete();
    }

    /**
     * View a blog
     *
     * @return blade file with array
     */
    public function show(Request $request)
    {
        $blog = Blogs::find($request->route('id'));

        return view('common.view-blog', compact('blog'));
    }
}
