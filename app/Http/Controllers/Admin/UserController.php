<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Models\Blogs;
use App\Models\AssignedUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Rendering admin users list and datatable
     *
     * @return blade file with array
     */
    public function index(Request $request)
    {
        $userQuery = User::select(
            'users.id',
            'first_name',
            'last_name',
            'email',
            'user_type',
            'last_login',
            DB::raw('COUNT(user_id) AS numBlogs')
        )->leftJoin('blogs', 'users.id', '=', 'user_id');

        if ($request->type) {
            $userQuery->where('user_type', $request->type);
        }
        

        $userList = $userQuery->groupBy('users.id')
            ->paginate(20);

        $sqlHelper = new \App\Library\SqlHelper();
        $userTypes = $sqlHelper->getEnumValues('users', 'user_type');
            
        return view('admin.user-list', compact('userList', 'userTypes'));
    }

    /**
     * Rendering user edit form with fillable values
     *
     * @return blade file with array
     */
    public function edit(Request $request)
    {
        $userDet = User::where('id', $request->route('id'))->first();

        $sqlHelper = new \App\Library\SqlHelper();
        $userTypes = $sqlHelper->getEnumValues('users', 'user_type');

        return view('admin.user-edit', compact('userDet', 'userTypes'));
    }

    /**
     * Updating a user
     *
     * @return void
     */
    public function update(Request $request)
    {
        $this->validate(request(), [
            'first_name'            => 'required|string|max:255',
            'last_name'             => 'required|string|max:255',
            'user_type'             => 'required',
            'email'                 => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($request->route('id'))
            ]
        ]);

        User::where('id', $request->route('id'))
            ->update([
                'first_name' => $request->first_name,
                'last_name'  => $request->last_name,
                'email'      => $request->email,
                'user_type'  => $request->user_type,
            ]);

        return redirect('admin/user-list');
    }

    /**
     * Rendering user create form with fillable values
     *
     * @return blade file with array
     */
    public function add(Request $request)
    {
        $sqlHelper = new \App\Library\SqlHelper();
        $userTypes = $sqlHelper->getEnumValues('users', 'user_type');

        return view('admin.user-add', compact('userTypes'));
    }

    /**
     * Creating a user
     *
     * @return void
     */
    public function store(Request $request)
    {
        $this->validate(request(), [
            'first_name'            => 'required|string|max:255',
            'last_name'             => 'required|string|max:255',
            'user_type'             => 'required',
            'password'              => 'required|min:6',
            'email'                 => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')
            ]
        ]);

        User::insert([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'email'      => $request->email,
            'user_type'  => $request->user_type,
            'password'   => Hash::make($request->password)
        ]);

        return redirect('admin/user-list');
    }

    /**
     * Deleteing user and related details from tables
     *
     * @return void
     */
    public function delete(Request $request)
    {
        User::where('id', $request->id)->delete();

        Blogs::where('user_id', $request->id)->delete();

        AssignedUsers::where('supervisor_id', $request->id)
            ->orWhere('blogger_id', $request->id)
            ->delete();
    }
}