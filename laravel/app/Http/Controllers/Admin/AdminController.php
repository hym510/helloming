<?php

namespace App\Http\Controllers\Admin;

use Hash;
use App\Models\Admin;
use App\Http\Requests\Admin\AdminRequest;
use App\Http\Controllers\Admin\Controller;

class AdminController extends Controller
{
    public function getIndex()
    {
        return view('admin.adminer.index', [
            'admins' => Admin::paginate()->appends(request()->all())
        ]);
    }

    public function getAdd()
    {
        return view('admin.adminer.edit');
    }

    public function getEdit($adminId)
    {
        return view('admin.adminer.edit', [
            'admin' => Admin::findOrFail($adminId)
        ]);
    }

    public function postStore(AdminRequest $request)
    {
        Admin::create([
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return redirect()->action('Admin\AdminController@getIndex');
    }

    public function postUpdate(AdminRequest $request, $adminId)
    {
        if ($request->password) {
            Admin::where('id', $adminId)
            ->update([
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);
        } else {
            Admin::where('id', $adminId)
            ->update([
                'email' => $request->email,
            ]);
        }

        return redirect()->action('Admin\AdminController@getIndex');
    }

    public function getDelete($adminId)
    {
        Admin::where('id', $adminId)->delete();

        return redirect()->action('Admin\AdminController@getIndex');
    }
}
