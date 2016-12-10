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
        ->where('activate', 1)
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

    public function postStore(UsersRequest $request)
    {
        $icon = $request->icon->store('uploads');
        $path = rtrim(config('find.uploads.webpath', '/') . '/' . ltrim($icon, '/'));
        $data = $request->inputData();
        unset($data['icon']);
        $data['icon'] = $path;
        User::create($data);

        return redirect()->action('Admin\UsersController@getIndex');
    }

    public function getDelete($userId, $type)
    {
        switch ($type) {
            case 'delete':
                User::where('id', $userId)->update(['activate' => 0]);
                break;
            case 'forcedelete':
                User::where('id', $userId)->forceDelete();
                break;
        }

        return redirect()->action('Admin\UsersController@getIndex');
    }
}
