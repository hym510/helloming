<?php

namespace App\Http\Controllers\Admin;

use Hash;
use App\Models\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminRequest;

class AdminController extends Controller
{
    public function getIndex()
    {
        $admins = Admin::paginate()->appends(request()->all());

        return view('admin.adminer.index', compact('admins'));
    }

    public function getEdit(Admin $admin)
    {
        $admin = $admin->mergeAttributesOld();

        return view('admin.adminer.edit', compact('admin'));
    }

    public function getData($id)
    {
        $admin = Admin::findOrFail($id);

        return view('admin.adminer.edit', compact('admin'));
    }

    public function postStore(AdminRequest $request)
    {
        $email = $request->email;
        $password = Hash::make($request->password);
        Admin::create(['email' => $email, 'password' => $password]);

        return redirect()->action('Admin\AdminController@getIndex');
    }

    public function postUpdate(AdminRequest $request, $id)
    {
        $admin = Admin::findOrFail($id);
        $admin->updata($request->all());

        return redirect()->action('Admin\AdminController@getIndex');
    }

    public function getDelete($id)
    {
        Admin::findOrFail($id)->delete();

        return redirect()->action('Admin\AdminController@getIndex');
    }
}
