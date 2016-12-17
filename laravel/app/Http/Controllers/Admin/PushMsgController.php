<?php

namespace App\Http\Controllers\Admin;

use Json;
use Pusher;
use App\Models\User;
use App\Models\Notification;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PushMsgRequest;

class PushMsgController extends Controller
{
    public function getPushMsg()
    {
        return view('admin.push.index');
    }

    public function postPushMsg(PushMsgRequest $request)
    {
        $data = $request->inputData();
        $notification = Notification::create($data);
        $id[] = User::pluck('id');
        Json::success(Pusher::pushMany($id, ['message' => $data['message']]));

        return redirect()->action('Admin\PushMsgController@getPushMsg');
    }
}
