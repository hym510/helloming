<?php

namespace App\Http\Controllers\Admin;

use Pusher;
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
        $data['id'] = $notification->id;

        return Pusher::pushOne($data['id'], ['message' => $data['message']]);
    }
}
