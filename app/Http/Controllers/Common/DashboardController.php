<?php

namespace App\Http\Controllers\Common;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Updating personal details
     *
     * @return null
     */
    public function update(Request $request)
    {
        $this->validate(request(), [
            'first_name'            => 'required|string|max:255',
            'last_name'             => 'required|string|max:255',
            'email'                 => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore(Auth::user()->id)
            ]
        ]);

        $user             = User::find(Auth::user()->id);
        $user->first_name = $request->first_name;
        $user->last_name  = $request->last_name;
        $user->email      = $request->email;
        $user->save();
    }

    /**
     * Rendering change password form
     *
     * @return blade file
     */
    public function changePassword()
    {
        return view('common.change-password');
    }

    /**
     * Validating and changing password
     *
     * @return blade file
     */
    public function changePasswordPost(Request $request)
    {
        $this->validate(request(), [
            'password'              => 'required|confirmed|min:6',
            'password_confirmation' => 'required|min:6',
        ]);

        $user           = User::find(Auth::user()->id);
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect(Auth::user()->user_type . '/dashboard');
    }
}
