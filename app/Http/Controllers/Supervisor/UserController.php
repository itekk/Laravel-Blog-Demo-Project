<?php

namespace App\Http\Controllers\Supervisor;

use App\Models\AssignedUsers;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Rendering bloggers assigned to a supervisors
     *
     * @return blade file with array
     */
    public function index()
    {
        $userList = AssignedUsers::where('supervisor_id', Auth::user()->id)
            ->paginate(20);

        return view('supervisor.user-list', compact('userList'));
    }
}