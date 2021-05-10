<?php

namespace App\Http\Commerce\Controllers;

use App\DataTables\ShopsDataTable;
use App\Http\Commerce\Models\Coupon;
use App\Http\Commerce\Models\Uploads;
use App\Http\Controllers\Controller;
use App\Http\Core\Models\Image;
use App\Http\Shop\Models\Shop;
use App\Support\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LogoController extends Controller
{


    /**
     * @param $takhfif
     * @return array
     */
    public function setDefaultOption(): array
    {
        $defaultOption = [
//            'size' => ['width' => 600, 'height' => 400],
            'watermark' => true,
            'changesize' => true,
            'dir' => 'img/logo/'
        ];
        return $defaultOption;
    }

    public function index(Request $request)
    {
        return view('panel.logos.logo');
    }

    public function loadImages()
    {
        return Image::where('imagable_type', 'LOGOS')->get();
    }

    public function uploadImages(Request $request)
    {

        $image = $this->ajaxSaveImage($request);

        return $image->id;
    }

    public function destroyImage(Image $image)
    {
//dd(1);
        $path = $image->path;
        $thumbnail = $image->thumbnail;
        $image->delete();
        //remove the image file
        try {
            if ($path) Image::removeImage($path);
            if ($thumbnail) Image::removeImage($thumbnail);
        } catch (\Exception $exception) {
            Log::info($exception);
        }

        return response()->json(['success' => 'با موفقیت حذف شد .']);

    }

    /**
     * @param Request $request
     * @param $takhfif
     * @return
     */
    public function ajaxSaveImage(Request $request)
    {
        $imageName = null;
        //set default option
        $defaultOption = $this->setDefaultOption();
        if ($request->hasFile('main_image')) {

            try {
                $upload = upload_image($request->file('main_image'), $defaultOption);
                $imageName = $upload[0];
                $thumbnail = $upload[1];
                return Image::create([
                    'path' => $imageName,
                    'thumbnail' => $thumbnail,
                    'imagable_id' => '1',
                    'imagable_type' => 'LOGOS'
                ]);
            } catch (\Exception $e) {
                Log::info($e);
            }

        }
    }

}
