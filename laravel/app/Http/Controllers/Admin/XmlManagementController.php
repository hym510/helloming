<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Library\Readfile\ReadFileUrl;
use App\Models\{XmlManagement, XmlUrl};
use App\Http\Requests\Admin\XmlManagementRequest;

class XmlManagementController extends Controller
{

    public function getIndex()
    {
        $xmlurl = XmlUrl::where('flag', 1)->first();
        $xmlmsgs = XmlManagement::where('mark', 1)->paginate()->appends(request()->all());

        return view('admin.xmlmsg.index', compact('xmlmsgs', 'xmlurl'));
    }

    public function getAdd()
    {
        return view('admin.xmlmsg.add');
    }

    public function postStoreFilename(XmlManagementRequest $request)
    {
        $data = $request->inputData();
        XmlManagement::create($data);
        $url = XmlUrl::where('flag', 1)->first();
        $file = explode('.', $data['xmlname']);
        $path = rtrim($url->urlname . $file[0] . '_' . $data['version'] . '.xml');
        $xml = file_get_contents($path);
        file_put_contents('uploads/' . $file[0] . '_' . $data['version'] . '.xml', $xml);

        return redirect()->action('Admin\XmlManagementController@getIndex');
    }

    public function getEdit($xmlId)
    {
        return view('admin.xmlmsg.edit', [
            'xmlmsg' => Xmlmanagement::findOrFail($xmlId)
        ]);
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
        $this->selectFile($oldversion['xmlname']);

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
        ReadFileUrl::fileGroupLoad();

        return $this->backSuccessMsg('修改成功');
    }

    protected function selectFile($filename)
    {
        switch ($filename) {
            case 'event.xml':
                ReadFileUrl::writeEvent('event.xml');
                break;
            case 'item.xml':
                ReadFileUrl::writeItem('item.xml');
                break;
            case 'equipRating.xml':
                ReadFileUrl::writeEquipLevel('equipRating.xml');
                break;
            case 'expense.xml':
                ReadFileUrl::writeExpense('expense.xml');
                break;
            case 'equip.xml':
                ReadFileUrl::writeEquipment('equip.xml');
                break;
            case 'job.xml':
                ReadFileUrl::writeJob('job.xml');
                break;
            case 'userPropery.xml':
                ReadFileUrl::writeLevel('userPropery.xml');
                break;
            case 'monster.xml':
                ReadFileUrl::writeMonster('monster.xml');
                break;
            case 'shop.xml':
                ReadFileUrl::writeShop('shop.xml');
                break;
            case 'userState.xml':
                ReadFileUrl::writeState('userState.xml');
                break;
            case 'freeShoe.xml':
                ReadFileUrl::writeFreeShoe('freeShoe.xml');
                break;
            case 'general.xml':
                ReadFileUrl::writeEventTime('general.xml');
                break;
        }
    }
}
