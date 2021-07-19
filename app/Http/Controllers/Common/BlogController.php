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

        Blogs::insert([
            'title'       => $request->title,
            'description' => $request->description,
            'user_id'     => Auth::user()->id,
            'created_at'  => date('Y-m-d h:i:s'),
        ]);

        return redirect(Auth::user()->user_type . '/blog-list');
    }

    /**
     * Rendering blog update layout with values
     *
     * @return blade file with array
     */
    public function update(Request $request)
    {
        $blogDet = Blogs::where('id', $request->route('id'))->first();

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

        Blogs::where('id', $request->route('id'))->update([
            'title'       => $request->title,
            'description' => $request->description,
            'updated_at'  => date('Y-m-d h:i:s'),
        ]);

        return redirect(Auth::user()->user_type . '/blog-list');
    }

    /**
     * Deleting a blog
     *
     * @return null
     */
    public function delete(Request $request)
    {
        Blogs::where('id', $request->route('id'))->delete();
    }

    /**
     * View a blog
     *
     * @return blade file with array
     */
    public function show(Request $request)
    {
        $blog = Blogs::where('id', $request->route('id'))->first();

        return view('common.view-blog', compact('blog'));
    }
}
