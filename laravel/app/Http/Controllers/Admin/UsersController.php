<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UsersRequest;

class UsersController extends Controller
{
    public function getIndex()
    {
        $users = User::with('job')->when(request('keyword'), function ($q) {
            return $q->where('phone', request('keyword'))
                ->orWhere('name', request('keyword'));
        })
        ->paginate()
        ->appends(request()->all());

        return view('admin.users.index', compact('users'));
    }

    public function getShow($id)
    {
        $user = User::findOrfail($id);

        return view('admin.users.show', compact('user'));
    }

    public function getEdit(User $user)
    {
        $user = $user->mergeAttributesOld();

        return view('admin.users.edit', compact('user'));
    }

    public function postStore(UsersRequest $request)
    {
        $user = $request->inputData();
        User::create($user);

        return redirect()->action('Admin\UsersController@getIndex');
    }

    public function getDelete($id, $type)
    {
        $user = User::findOrFail($id);
        switch ($type) {
            case 'delete':
                $user->delete();
                break;
            case 'forcedelete':
                $user->forceDelete();
                break;
        }
    }
}