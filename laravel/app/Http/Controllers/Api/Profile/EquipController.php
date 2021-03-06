<?php

namespace App\Http\Controllers\Api\Profile;

use Auth;
use Json;
use App\Library\Profile\Equip;
use Illuminate\Routing\Controller;

class EquipController extends Controller
{
    public function getUpgrade($position)
    {
        $result = Equip::upgrade(Auth::user()->user, $position);

        switch ($result) {
            case 'max':
                return Json::error('Max level already reached.', 215);
            case 'lack':
                return Json::error('Lack of material resources.', 501);
            case 'success':
                return Json::success();
        }
    }
}
