<?php

namespace App\Http\Controllers\Admin;

use App\Models\Notification;
use App\Contracts\Push\Pusher;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PushMsgRequest;

class PushMsgController extends Controller
{
    private $pusher;

    public function __construct(Pusher $pusher)
    {
        $this->pusher = $pusher;
    }

    public function getPushMsg()
    {
        return view('admin.push.index');
    }

    public function postPushMsg(PushMsgRequest $request)
    {
        $data = $request->inputData();
        $notification = Notification::create($data);
        $data['id'] = $notification->id;

        return $this->pusher->pushOne($data['id'], ['message' => $data['message']]);
    }
}
