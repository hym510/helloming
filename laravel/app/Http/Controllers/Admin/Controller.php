<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    protected function backSuccessMsg($success_msg)
    {
        return back()->withInput([
            'success_msg' => $success_msg,
        ]);
    }
}
