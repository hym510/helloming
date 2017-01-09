<?php

namespace App\Http\Controllers\Admin;

use Pusher;
use Carbon\Carbon;
use App\Models\User;
use App\Http\Controllers\Admin\Controller;
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
        $time = Carbon::createFromFormat('Y-m-d H:i:s', $data['time']);
        $time->setTimezone('UTC');

        Pusher::pushMany(['alert' => $data['message'], 'push_time' => $time]);

        return $this->backSuccessMsg('推送成功');
    }
}
