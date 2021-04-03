<?php

namespace App\Http\Shop\Controllers;

use App\Http\Controllers\Controller;

use App\Http\Core\Models\Image;
use App\Http\Shop\Models\Shop;
use App\Support\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LicencesController extends Controller
{
    /**
     * @param $shop
     * @return array
     */
    public function setDefaultOption($shop): array
    {
        $defaultOption = [
            'size' => ['width' => 600, 'height' => 400],
            'watermark' => true,
            'changesize' => true,
            'dir' => 'img/shop/' . $shop->id
        ];
        return $defaultOption;
    }

    public function index()
    {
        $shop = Shop::find(1);
        $licence = $shop->licence;
        $userid = $shop->userid;
        return view('shop.licence.index', compact('shop', 'licence', 'userid'));
    }

    public function update(Request $request, $profiles)
    {
        $shop = Shop::findOrfail($profiles);
        if ($request->userid=='undefined')
            $request->offsetUnset('userid');

        if ($request->licence=='undefined')
            $request->offsetUnset('licence');

//        dd($request->all());
        $request->validate([
            'userid' => [ 'image', 'mimes:jpg,jpeg,png,svg'],
            'licence' => [ 'image', 'mimes:jpg,jpeg,png,svg'],
        ]);


        try {
            //save curent path for ramove
            $file = $request->file('licence');
            if ($file) {
                $extention = '.' . $file->getClientOriginalExtension();
                $imageName = uniqid() . md5($file->getClientOriginalName()) . $extention;
                //save file to folder

                $imgaddress = $file->move('img/shop/certificates/' . $shop->id, $imageName)->getpathname();
                $shop->licence()->create([
                    'type' => 'licence',
                    'src' => $imgaddress
                ]);
            }

        } catch (\Exception $e) {
            Log::info($e);
        }

        try {
            //save curent path for ramove
            $file = $request->file('userid');
            if ($file) {
                $extention = '.' . $file->getClientOriginalExtension();
                $imageName = uniqid() . md5($file->getClientOriginalName()) . $extention;
                //save file to folder

                $imgaddress = $file->move('img/shop/userids/' . $shop->id, $imageName)->getpathname();
                $shop->userid()->create([
                    'type' => 'userid',
                    'src' => $imgaddress
                ]);
            }

        } catch (\Exception $e) {
            Log::info($e);
        }

        return JsonResponse::sendJsonResponse(1, 'موفق', sprintf('پروفایل  %s  با موفقیت ویرایش شد', $shop->shop_name),
            'REFRESH');
    }


}
