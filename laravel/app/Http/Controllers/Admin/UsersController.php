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

    public function getShow($userId)
    {
        return view('admin.users.show', ['user' => User::findOrfail($userId)]);
    }

    public function getAdd()
    {
        return view('admin.users.edit');
    }

    public function getDelete($userId, $type)
    {
        switch ($type) {
            case 'freeze':
                User::where('id', $userId)->update(['activate' => 0]);
                break;
            case 'unfreeze':
                User::where('id', $userId)->update(['activate' => 1]);
                break;
            case 'delete':
                User::where('id', $userId)->delete();
                break;
        }

        return redirect()->action('Admin\UsersController@getIndex');
    }
}
