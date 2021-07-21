<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Blogs;
use App\Models\AssignedUsers;
use Illuminate\Support\Facades\Auth;

class CanAccessBlog
{
    /**
     * Get the path that the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    public function handle($request, Closure $next)
    {
        if (Auth::user()->user_type == 'admin') {
            return $next($request);
        } else {
            $blogDet = Blogs::find($request->route('id'));
            if (Auth::user()->user_type == 'supervisor') {
                $assignedBlogers = AssignedUsers::where('supervisor_id', Auth::user()->id)
                    ->get()
                    ->pluck('blogger_id')
                    ->toArray();
                if (in_array($blogDet->user_id, $assignedBlogers) || $blogDet->user_id == Auth::user()->id) {
                    return $next($request);
                } else {
                    return redirect(Auth::user()->user_type . '/no-permission');
                }
            } else {
                if ($blogDet->user_id == Auth::user()->id) {
                    return $next($request);
                } else {
                    return redirect(Auth::user()->user_type . '/no-permission');
                }
            }
        }
    }
}
