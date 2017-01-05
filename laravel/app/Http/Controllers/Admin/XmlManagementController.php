<?php

namespace App\Http\Controllers\Admin;

use App\Library\Readfile\ReadFileUrl;
use Illuminate\Http\Request;
use App\Models\{XmlManagement, XmlUrl};
use App\Http\Controllers\Admin\Controller;
use App\Http\Requests\Admin\XmlManagementRequest;

class XmlManagementController extends Controller
{

    public function getIndex()
    {
        $xmlurl = XmlUrl::where('flag', 1)->first();
        $xmlmsgs = XmlManagement::where('mark', 1)->paginate()->appends(request()->all());

        return view('admin.xmlmsg.index', compact('xmlmsgs', 'xmlurl'));
    }

    public function getEdit($xmlId)
    {
        $xmlmsg = Xmlmanagement::findOrFail($xmlId);

        return view('admin.xmlmsg.edit', compact('xmlmsg'));
    }

    public function postStoreVersion(XmlManagementRequest $request, $xmlId)
    {
        $oldversion = XmlManagement::where('id', $xmlId)->first();
        $xmlmsg = $request->inputData();
        if (strcmp($xmlmsg['version'], $oldversion['version']) < 0) {
            return $this->backSuccessMsg('设置的版本小于当前版本');
        }
        XmlManagement::where('id', $xmlId)->update(['mark' => 0]);
        $url = XmlUrl::where('flag', 1)->first();
        $file = explode('.', $oldversion['xmlname']);
        $path = rtrim($url->urlname. $file[0] . '_' . $xmlmsg['version'] . '.xml');
        $xml = file_get_contents($path);
        file_put_contents('uploads/' . $file[0] . '_' . $xmlmsg['version'] . '.xml', $xml);
        $array = ['mark' => 1];
        $all = array_collapse([$xmlmsg, $array, ['xmlname' => $oldversion['xmlname']]]);
        XmlManagement::create($all);
        $this->SelectFile($oldversion['xmlname']);

        return redirect()->action('Admin\XmlManagementController@getIndex');
    }

    public function getShow($xmlId)
    {
        $xmlmsg = XmlManagement::findOrFail($xmlId);
        $datas = XmlManagement::get();
        foreach ($datas as $data) {
            if ($xmlmsg->xmlname == $data->xmlname) {
                $xmldatas[] = [
                    'version' => $data['version'],
                    'created_at' => $data['created_at'],
                ];
            }
        }

        return view('admin.xmlmsg.show', compact('xmldatas', 'xmlmsg'));
    }

    public function postModifyUrl($xmlId, Request $request)
    {
        XmlUrl::where('id', $xmlId)->update(['flag' => 0]);
        XmlUrl::create(['urlname' => $request->val]);
        $filedatas = XmlManagement::get();
        ReadFileUrl::FileGroupLoad();
        return $this->backSuccessMsg('修改成功');
    }

    protected function SelectFile($filename)
    {
        switch ($filename) {
            case 'event.xml':
                ReadFileUrl::WriteEvent('event.xml');
                break;
            case 'item.xml':
                ReadFileUrl::WriteItem('item.xml');
                break;
            case 'equipRating.xml':
                ReadFileUrl::WriteEquipLevel('equipRating.xml');
                break;
            case 'expense.xml':
                ReadFileUrl::WriteExpense('expense.xml');
                break;
            case 'equip.xml':
                ReadFileUrl::WriteEquipment('equip.xml');
                break;
            case 'job.xml':
                ReadFileUrl::WriteJob('job.xml');
                break;
            case 'userPropery.xml':
                ReadFileUrl::WriteLevel('userPropery.xml');
                break;
            case 'monster.xml':
                ReadFileUrl::WriteMonster('monster.xml');
                break;
            case 'shop.xml':
                ReadFileUrl::WriteShop('shop.xml');
                break;
            case 'userState.xml':
                ReadFileUrl::WriteState('userState.xml');
                break;
        }
    }
}
