<?php

namespace App\Http\Shop\Controllers;

use App\Http\Core\Models\Image;
use App\Http\Shop\Models\Shop;
use App\Http\Shop\Models\Takhfif;
use App\Http\Controllers\Controller;
use App\Rules\DateCheck;
use App\Support\JsonResponse;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TakhfifController extends Controller
{
    /**
     * @param $takhfif
     * @return array
     */
    public function setDefaultOption($takhfif): array
    {
        $defaultOption = [
            'size' => ['width' => 600, 'height' => 400],
            'watermark' => true,
            'changesize' => true,
            'dir' => 'img/takhfif/' . $takhfif->id
        ];
        return $defaultOption;
    }

    /**
     *
     */
    public function index()
    {

//        $datatable = new BannerDataTable($query);

//        return $datatable->render('panel.banner.index');
        $takhfifs = Takhfif::all();
        return view('shop.takhfifs.index',compact('takhfifs'));
    }

    public function edit(Takhfif $takhfif)
    {
//        dd($takhfif);
        $shop = Shop::find(1);
        $parameters = $takhfif->parameters;
        $terms = $takhfif->terms;
        return view('shop.takhfifs.create', compact('takhfif', 'shop', 'parameters', 'terms'));

    }

    /**
     * @param Request $request
     * @return false|string
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:999'],

        ]);
        $shop = Shop::find(1);

        $takhfif = $shop->takhfifs()->create($request->all());

        if ($request->slug)
            $takhfif->slug = sprintf('%s-%s', $takhfif->id, str_slug_persian($request->slug));
        else
            $takhfif->slug = sprintf('%s-%s', $takhfif->id, str_slug_persian($takhfif->name));

        $takhfif->save();

        return JsonResponse::sendJsonResponse(1, 'موفق', sprintf('تخفیف  %s  با موفقیت ایجاد گردید', $takhfif->name),
            'REDIRECT', route('shop.takhfifs.edit', $takhfif->id));
    }


    /**
     * @param Request $request
     * @param Takhfif $takhfif
     * @return false|string
     */
    public function update(Request $request, Takhfif $takhfif)
    {

        $timesMap = [
            'display_start_time',
            'display_end_time',
            'start_time',
            'expire_time',
        ];


        foreach ($timesMap as $time) {
            if ($request->has($time)) {
                $request->merge([
                    $time => fa_to_en($request->$time),
                ]);
            }
        }
//        dd($request->all());
        $request->validate([
            'tags' => ['required', 'array'],
            'categories' => ['required', 'array'],
            'categories.*' => ['integer', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:999'],
            'display_start_time' => ['required', 'string', new DateCheck],
            'display_end_time' => ['required', 'string', new DateCheck],
            'start_time' => ['required_with:expire_time', new DateCheck],
            'expire_time' => ['required_with:start_time', 'string', new DateCheck],
            'time_out' => ['required_without_all:expire_time,start_time', 'integer', 'max:999'],
            'capacity' => ['digits_between:0,999999999999'],
            'vip' => ['in:0,1'],
//            'shop_id' => ['required', 'string', 'max:999'],
            'description' => ['required', 'string', 'max:5000'],
            'active' => ['in:0,1'],
            'approved' => ['in:0,1'],
            'price' => ['required', 'digits_between:0,999999999999'],
//            'discount' => ['required', 'digits_between:0,999999999999'],
            'discount_price' => ['required', 'digits_between:0,999999999999'],
        ]);


        foreach ($timesMap as $time) {
            if ($request->has($time)) {
                $request->merge([
                    $time => $this->convertToGregorianTimeStamp($request->$time),
                ]);
            }
        }
        if ($request->has('tags')) {
            $request->merge([
                'tags' => implode(',',$request->tags),
            ]);
        }



        $takhfif->update($request->all());
        $takhfif->categories()->sync($request->categories);

        if ($request->slug)
            $takhfif->slug = sprintf('%s-%s', $takhfif->id, str_slug_persian($request->slug));
        else
            $takhfif->slug = sprintf('%s-%s', $takhfif->id, str_slug_persian($takhfif->name));

        $takhfif->save();

        return JsonResponse::sendJsonResponse(1, 'موفق', sprintf('تخفیف  %s  با موفقیت ویرایش شد', $takhfif->name),
            'REDIRECT', route('shop.takhfifs.index'));
    }

    /**
     * @param Takhfif $takhfif
     * @return false|string
     */
    public function destroy(Takhfif $takhfif)
    {
        $name = $takhfif->name;
        $takhfif->delete();
        return JsonResponse::sendJsonResponse(1, 'موفق', sprintf('تخفیف %s با موفقیت حذف گردید', $name),
            'REFRESH');
    }


    public function toggle(Request $request, Takhfif $takhfif)
    {
//        dd($takhfif);
//        if (!Auth::user()->can('update-takhfif')) {
//            return back()->with('error-message', 'دسترسی شما به این بخش محدود می باشد!');
//        }

        $takhfif->active = !$takhfif->active;
        $takhfif->save();
        if ($request->ajax()) return response()->json(['message' => 'با موفقیت ذخیره شد .', 'active' => $takhfif->active]);

        return back();
    }

    public function ajaxTakhfifList(Request $request)
    {

        $data = $data = DB::table("takhfifs")
            ->select("id", "title")
            ->where('active', 1)
            ->limit(20)
            ->get();;


        if ($request->has('q')) {
            $search = $request->q;
            $data = DB::table("takhfifs")
                ->select("id", "title")
                ->where('active', 1)
                ->where('title', 'LIKE', "%$search%")
                ->limit(15)
                ->get();
        }


        return response()->json($data);

    }

    public function ajaxCategoriesList(Request $request)
    {

        $data = $data = DB::table("categories")
            ->select("id", "name")
            ->where('active', 1)
            ->limit(20)
            ->get();;


        if ($request->has('q')) {
            $search = $request->q;
            $data = DB::table("categories")
                ->select("id", "name")
                ->where('active', 1)
                ->where('name', 'LIKE', "%$search%")
                ->limit(15)
                ->get();
        }


        return response()->json($data);

    }

    public function loadImages(Takhfif $takhfif)
    {
        return $takhfif->images;
    }

    public function uploadImages(Request $request, Takhfif $takhfif)
    {

//todo set it in settings
//        if ($takhfif->images->count() >= 5)
//            return response('حداکثر تعداد فایل اپلودی رد شده است .', 400);

        $image = $this->ajaxSaveImage($request, $takhfif);

        return $image->id;
    }

    public function destroyImage(Image $image)
    {

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
    public function ajaxSaveImage(Request $request, $takhfif)
    {
        $imageName = null;
        //set default option
        $defaultOption = $this->setDefaultOption($takhfif);
        if ($request->hasFile('main_image')) {

            try {
                $upload = upload_image($request->file('main_image'), $defaultOption);
                $imageName = $upload[0];
                $thumbnail = $upload[1];
                return $takhfif->images()->create([
                    'path' => $imageName,
                    'thumbnail' => $thumbnail,
                    'title' => $takhfif->name
                ]);
            } catch (\Exception $e) {
                Log::info($e);
            }

        }
    }

    /**
     * @param $display_start_time
     * @return string
     */
    public function convertToGregorianTimeStamp($display_start_time): string
    {
        $display_start_time = explode('-', fa_to_en($display_start_time));
        $time = $display_start_time[3];
        $display_start_time = Verta::getGregorian($display_start_time[0], $display_start_time[1], $display_start_time[2]);
        $display_start_time = implode('-', $display_start_time) . ' ' . $time;
        return $display_start_time;
    }
}
