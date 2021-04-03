<?php

namespace App\Http\Core\Controllers;

use App\DataTables\SliderDataTable;
use App\Http\Core\Models\Slider;
use App\Http\Controllers\Controller;
use App\Support\JsonResponse;
use Hekmatinasser\Verta\Verta;
use Illuminate\Http\Request;

class SliderController extends Controller
{

    public function index(Request $request)
    {
//        if (!Auth::user()->can('create-slider')) {
//            return back()->with('error-message', 'دسترسی شما به این بخش محدود می باشد!');
//        }
//dd(1);

        $start_time = null;
        $end_time = null;
        if ($request->searchByStartTime !== null && $request->has('searchByStartTime')) {
            $start_time = fa_to_en($request->searchByStartTime);
            $start_time = explode('-', $start_time);
            $time = $start_time[3];
            $start_time = Verta::getGregorian($start_time[0], $start_time[1], $start_time[2]);
            $start_time = implode('-', $start_time);
            $start_time = $start_time . ' ' . $time;
        }

        if ($request->searchByEndTime !== null && $request->has('searchByEndTime')) {
            $end_time = fa_to_en($request->searchByEndTime);
            $end_time = explode('-', $end_time);
            $time = $end_time[3];
            $end_time = Verta::getGregorian($end_time[0], $end_time[1], $end_time[2]);
            $end_time = implode('-', $end_time);
            $end_time = $end_time . ' ' . $time;

        }
        $query = Slider::with('image');


        if ($start_time) {
            $query->where('start_time','>=', $start_time);
        }

        if ($end_time) {
            $query->where('expire_time','<=', $end_time);
        }

        if ($request->searchById) {
            $query->where('id', 'LIKE', '%' . $request->searchById . '%');
        }

        if ($request->searchByName) {
            $query->where('name', 'LIKE', '%' . $request->searchByName . '%');
        }


        if ($request->searchByCategory) {
            $query->where('category_id',   $request->searchByCategory );

        }
        if ($request->searchByPlace) {
            $query->where('place_id',   $request->searchByPlace );
        }

        if ($request->searchByAscDesc) {
            $ascDesc = $request->searchByAscDesc;

        } else {
            $ascDesc = 'DESC';
        }

        if ($request->searchSortBy) {
            $searchSortBy = $request->searchSortBy;
            if ($ascDesc == 'DESC')
                $query->latest($searchSortBy);
            else
                $query->oldest($searchSortBy);

        } else
            $query->latest('position');


        $datatable = new SliderDataTable($query);

        return $datatable->render('panel.slider.index');
    }

    public function create()
    {

        return view('panel.slider.slider-create');
    }

    public function store(Request $request)
    {
//        dd($request->all());
//        if (!Auth::user()->can('read-slider')) {
//            return back()->with('error-message', 'دسترسی شما به این بخش محدود می باشد!');
//        }


        $this->sliderValidator($request);
        $this->persianTimeStampToGregorian($request);

        $slider = Slider::create($request->all());

        $file = $request->file('main_image');
        if ($file) {
            $name = time() . $file->getClientOriginalName();
            $dir='img/slider/'.$slider->id;
            $file->move($dir, $name);
            $slider->image()->create([
                'path' => $dir.'/'.$name,
                'thumbnail' => '',
                'title' => $slider->name
            ]);
        }


      return  JsonResponse::sendJsonResponse(1, 'موفق', sprintf('اسلایدر  %s  با موفقیت ایجاد گردید', $slider->name),
            'REDIRECT', route('sliders.index'));

    }


    public function update(Request $request, Slider $slider)
    {
//        if (!Auth::user()->can('update-slider')) {
//            return back()->with('error-message', 'دسترسی شما به این بخش محدود می باشد!');
//        }
        $this->sliderValidator($request);

        $this->persianTimeStampToGregorian($request);

        $slider->update($request->all());
        $file = $request->file('main_image');
        if ($file) {
            $name = time() . $file->getClientOriginalName();
            $dir='img/slider/'.$slider->id;
            $file->move($dir, $name);
            $slider->image()->delete();
            $slider->image()->create([
                'path' => $dir.'/'.$name,
                'thumbnail' => '',
                'title' => $slider->name
            ]);
        }

       return JsonResponse::sendJsonResponse(1, 'موفق', sprintf('اسلایدر  %s  با موفقیت روز رسانی گردید', $slider->name),
            'REDIRECT', route('sliders.index'));

    }

    public function destroy(Slider $slider)
    {
//        if (!Auth::user()->can('delete-slider')) {
//            return back()->with('error-message', 'دسترسی شما به این بخش محدود می باشد!');
//        }

        //check if has product or items


        $slider->delete();

        return back()->with('message', sprintf('اسلایدر  %s  با موفقیت حذف گردید', $slider->name));

    }

    /**
     * @param Request $request
     */
    public function sliderValidator(Request $request): void
    {

        $start_time = fa_to_en($request->start_time);
        $end_time = fa_to_en($request->expire_time);
        $request->merge([
            'start_time' => $start_time,
            'expire_time' => $end_time,
        ]);
        if ($request->main_image=='undefined')
            $request->offsetUnset('main_image');
//        dd(($request->all()));
        $request->validate([
            'name' => 'required|string|min:2|max:254',
            'category_id' => ['nullable', 'integer', 'exists:categories,id'],
            'place_id' => ['nullable', 'integer', 'exists:places,id'],
            'takhfif_id' => ['nullable', 'integer', 'exists:takhfifs,id'],
            'button_text' => 'required|string|min:2|max:50',
            'button_link' => 'required|string|min:2|max:100',
            'start_time' => 'required|jdatetime:Y-m-d-H:i:s',
            'expire_time' => 'required|jdatetime:Y-m-d-H:i:s',
            'position' => 'integer',
            'active' => 'integer',
           'main_image' => ($request->_method=='put' ?'nullable|' :'required|').'image|mimes:jpg,jpeg,png,svg',

        ]);
    }

    /**
     * @param Request $request
     */
    public function persianTimeStampToGregorian(Request $request): void
    {
        if ($request->start_time !== null && $request->has('start_time')) {
            $start_time = fa_to_en($request->start_time);
            $start_time = explode('-', $start_time);
            $time = $start_time[3];
            $start_time = Verta::getGregorian($start_time[0], $start_time[1], $start_time[2]);
            $start_time = implode('-', $start_time);
            $start_time = $start_time . ' ' . $time;

        }

        if ($request->expire_time !== null && $request->has('expire_time')) {
            $end_time = fa_to_en($request->expire_time);
            $end_time = explode('-', $end_time);
            $time = $end_time[3];
            $end_time = Verta::getGregorian($end_time[0], $end_time[1], $end_time[2]);
            $end_time = implode('-', $end_time);
            $end_time = $end_time . ' ' . $time;

        }
//dd($start_time,$end_time);
        $request->merge([
            'start_time' => $start_time,
            'expire_time' => $end_time,
        ]);
    }
    public function activeToggle(Request $request, Slider $slider)
    {
//        dd($slider);
//        if (!Auth::user()->can('update-users')) {
//            return back()->with('error-message', 'دسترسی شما به این بخش محدود می باشد!');
//        }

        $slider->active = !$slider->active;
        $slider->save();
        if ($request->ajax()) return response()->json(['message' => 'با موفقیت ذخیره شد .', 'active' => $slider->active]);

        return back();
    }

    public function edit(Slider $slider)
    {
        return view('panel.slider.slider-edit', compact('slider'));
    }


}
