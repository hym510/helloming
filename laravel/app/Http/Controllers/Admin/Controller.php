<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    protected function backSuccessMsg($msg)
    {
        return back()->withInput([
            'success_msg' => $msg,
        ]);
    }
}
