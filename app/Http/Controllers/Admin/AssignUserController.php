<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Models\AssignedUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AssignUserController extends Controller
{
    /**
     * Rendering blade file with values for assigning supervisor to bloggers
     *
     * @return blade file with array
     */
    public function assignSupervisors(Request $request)
    {
        $supervisors = User::select(
            'id',
            'first_name',
            'last_name',
            'email'
        )->where('user_type', 'supervisor')
        ->get();

        $bloggerList      = [];
        $assignedBloggers = [];
        if ($request->id) {
            $bloggerList = User::select(
                'id',
                'first_name',
                'last_name',
                'email'
            )->where('user_type', 'blogger')
            ->get();

            $assignedBloggers = AssignedUsers::where('supervisor_id', $request->id)
                ->get()
                ->pluck('blogger_id')
                ->toArray();
        }

        return view('admin.assign-supervisors', compact('supervisors', 'bloggerList', 'assignedBloggers'));
    }

    /**
     * Rendering blade file with values for assigning bloggers to supervisor
     *
     * @return blade file with array
     */
    public function assignBloggers(Request $request)
    {
        $bloggers = User::select(
            'id',
            'first_name',
            'last_name',
            'email'
        )->where('user_type', 'blogger')
        ->get();

        $supervisorList      = [];
        $assignedSupervisor = [];
        if ($request->id) {
            $supervisorList = User::select(
                'id',
                'first_name',
                'last_name',
                'email'
            )->where('user_type', 'supervisor')
            ->get();

            $assignedSupervisor = AssignedUsers::where('blogger_id', $request->id)
                ->get()
                ->pluck('supervisor_id')
                ->toArray();
        }

        return view('admin.assign-bloggers', compact('bloggers', 'supervisorList', 'assignedSupervisor'));
    }

    /**
     * Assigning supervisor to bloggers
     *
     * @return redirect to user list page
     */
    public function assignSupervisorsPost(Request $request)
    {
        $this->validate(request(), [
            'supervisorId' => 'required'
        ]);

        $bloggerArr = [];
        if ($request->bloggerId) {
            $bloggerArr = $request->bloggerId;
        }
        AssignedUsers::where('supervisor_id', $request->supervisorId)
            ->whereNotIn('blogger_id', $bloggerArr)
            ->delete();
        
        foreach ($bloggerArr as $row) {
            DB::table('assigned_users')->updateOrInsert(
                [
                    'supervisor_id' => $request->supervisorId,
                    'blogger_id'    => $row
                ],
                [
                    'supervisor_id' => $request->supervisorId,
                    'blogger_id'    => $row
                ]
            );
        }

        return redirect('admin/user-list');
    }

    /**
     * Assigning bloggers to supervisor
     *
     * @return redirect to user list page
     */
    public function assignBloggersPost(Request $request)
    {
        $this->validate(request(), [
            'bloggerId' => 'required'
        ]);

        $supervisorArr = [];
        if ($request->supervisorId) {
            $supervisorArr = $request->supervisorId;
        }
        AssignedUsers::where('blogger_id', $request->bloggerId)
            ->whereNotIn('supervisor_id', $supervisorArr)
            ->delete();

        foreach ($supervisorArr as $row) {
            AssignedUsers::updateOrInsert(
                [
                    'supervisor_id' => $row,
                    'blogger_id'    => $request->bloggerId
                ],
                [
                    'supervisor_id' => $row,
                    'blogger_id'    => $request->bloggerId
                ]
            );
        }

        return redirect('admin/user-list');
    }
}