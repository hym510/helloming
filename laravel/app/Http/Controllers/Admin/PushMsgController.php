<?php

namespace App\Http\Controllers\Admin;

use Pusher;
use App\Models\User;
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
        Pusher::pushMany(['alert' => $data['message']]);

        return $this->backSuccessMsg('推送成功');
    }
}
