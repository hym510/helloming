<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Http\Controllers\Admin\Controller;

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

    public function getShow($userId)
    {
        return view('admin.users.show', ['user' => User::findOrfail($userId)]);
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
