<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Models\Blogs;
use App\Models\AssignedUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
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
        $userQuery = User::orderByDesc('updated_at');

        if ($request->type) {
            $userQuery->where('user_type', $request->type);
        }

        $userList = $userQuery->paginate(20);

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
        $userDet = User::find($request->route('id'));

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

        $user             = User::find($request->route('id'));
        $user->first_name = $request->first_name;
        $user->last_name  = $request->last_name;
        $user->email      = $request->email;
        $user->user_type  = $request->user_type;
        $user->updated_at = date('Y-m-d h:i:s');
        $user->save();

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
        
        $user             = new User;
        $user->first_name = $request->first_name;
        $user->last_name  = $request->last_name;
        $user->email      = $request->email;
        $user->user_type  = $request->user_type;
        $user->password   = Hash::make($request->password);
        $user->save();

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