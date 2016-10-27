<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    public function getIndex()
    {
        $users = User::when(request('keyword'), function ($q) {
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
