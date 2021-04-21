<?php

namespace App\Http\Core\Controllers;

use App\Http\Commerce\Models\Category;
use App\Http\Core\Models\Image;
use App\Http\Core\Models\Menu;
use App\Http\Controllers\Controller;
use App\Support\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MenuController extends Controller
{

    /**
     * @param $product
     * @return array
     */
    public function setDefualtOption($menu): array
    {
        $defaultOption = [
            'size' => ['width' => 200, 'height' => 200],
            'watermark' => false,
            'changesize' => true,
            'dir' => 'img/Menu/' . $menu->id
        ];
        return $defaultOption;
    }

    public function index()
    {
//        if (!Auth::user()->can('read-menu')) {
//            return back()->with('error-message', 'دسترسی شما به این بخش محدود می باشد!');
//        }

        $categories = Category::whereDoesntHave('category')->select('name', 'id')->get();
        $menus = Menu::with('categories', 'image')->oldest('position')->get();

        return view('panel.menu.index', compact('categories', 'menus'));
    }

    public function toggle(Request $request, Menu $menu)
    {
//        dd($menu);
//        if (!Auth::user()->can('update-menu')) {
//            return back()->with('error-message', 'دسترسی شما به این بخش محدود می باشد!');
//        }

        $menu->update([
            'active' => !$menu->active
        ]);
        return response()->json(['message' => 'با موفقیت ذخیره شد .', 'active' => $menu->active]);

    }


    public function store(Request $request)
    {
//        dd($request->all());
//        if (!Auth::user()->can('create-menu')) {
//            return back()->with('error-message', 'دسترسی شما به این بخش محدود می باشد!');
//        }
        $request->validate([
            'name' => 'required|string|min:2|max:254|unique:menus',
            'menu' => ['required'],
            'link' => ['required', 'min:2', 'max:254'],
            'icon' => ['required', 'min:2', 'max:254'],
            'slug' => ['nullable', 'string', 'min:2', 'max:254', 'unique:menus,slug'],
            'main_image' => 'nullable|image|mimes:jpg,jpeg,png|max:10240',

        ]);

        $menu = Menu::create($request->all());
        $menu->slug = sprintf('%s-%s', $menu->id, str_slug_persian($menu->name));
        $menu->save();
        $this->saveImage($request, $menu);

        $menu->categories()->sync($request->category_id);

        return JsonResponse::sendJsonResponse(1, 'موفق', sprintf('منوی %s با موفقیت ایجاد گردید', $menu->name),
            'REFRESH');
    }

    /**
     * @param Request $request
     * @param $menu
     */
    public function saveImage(Request $request, $model)
    {
        $imageName = null;
        //set default option
        $defaultOption = $this->setDefualtOption($model);

        if ($request->hasFile('main_image')) {
            try {
                $upload = upload_image($request->file('main_image'), $defaultOption);
                $imageName = $upload[0];
                $thumbnail = $upload[1];
                return $model->image()->create([
                    'path' => $imageName,
                    'thumbnail' => $thumbnail,
                    'title' => $model->name
                ]);
            } catch (\Exception $e) {
                Log::info($e);
            }

        }

    }

    public function update(Request $request, Menu $menu)
    {
//        dd($request->all());

//        if (!Auth::user()->can('update-menu')) {
//            return back()->with('error-message', 'دسترسی شما به این بخش محدود می باشد!');
//        }

        if ($request->main_image == 'undefined')
            $request->offsetUnset('main_image');
        $request->validate([
            'name' => 'required|string|min:3|max:254|unique:menus,name,' . $menu->id,
            'menu' => ['required'],
            'link' => ['required', 'min:2', 'max:254'],
            'icon' => ['required', 'min:2', 'max:254'],
            'slug' => ['nullable', 'string', 'min:2', 'max:254', 'unique:menus,slug,' . $menu->id],
            'main_image' => 'nullable|image|mimes:jpg,jpeg,png|max:10240',
        ]);

        $defaultOption = $this->setDefualtOption($menu);

        $menu->update($request->all());
        $menu->slug = sprintf('%s-%s', $menu->id, str_slug_persian($menu->name));
        $menu->save();

        if ($request->hasFile('main_image')) {
            try {
                $path = $menu->image->path;
                $thumbnail = $menu->image->thumbnail;

                if ($path && $path !== Image::NO_IMAGE_PATH) {
                    $menu->image->delete();
                    Image::removeImage($path);
                    if ($thumbnail) Image::removeImage($thumbnail);
                }

                $upload = upload_image($request->file('main_image'), $defaultOption);
                $imageName = $upload[0];
                $thumbnail = $upload[1];
                $menu->image()->create([
                    'path' => $imageName,
                    'thumbnail' => $thumbnail,
                    'title' => $menu->name
                ]);
            } catch (\Exception $e) {
                Log::info($e);
            }
        }

        $menu->categories()->sync($request->category_id);

        return JsonResponse::sendJsonResponse(1, 'موفق', sprintf('منوی %s با موفقیت ویرایش گردید', $menu->name),
            'REDIRECT',route('menus.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Http\Core\Models\Menu $menu
     * @throws \Exception
     */
    public function destroy(Menu $menu)
    {
//        if (!Auth::user()->can('delete-menu')) {
//            return back()->with('error-message', 'دسترسی شما به این بخش محدود می باشد!');
//        }

//check if has product or subcategory
        $name = $menu->name;
        $menu->delete();

        return JsonResponse::sendJsonResponse(1, 'موفق', sprintf('منوی %s با موفقیت حذف گردید', $name),
            'REFRESH');
    }

    public function edit(Menu $menu)
    {
        return view('panel.menu.menu-edit', compact('menu'));
    }
}
