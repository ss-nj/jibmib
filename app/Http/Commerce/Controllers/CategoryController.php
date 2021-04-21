<?php

namespace App\Http\Commerce\Controllers;

use App\DataTables\CategoryDataTable;
use App\Http\Commerce\Models\Attribute;
use App\Http\Commerce\Models\Category;
use App\Http\Controllers\Controller;
use App\Http\Core\Models\Image;
use App\Support\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{

    /**
     * @var array
     */
    private $defaultOption;


    public function setDefaultOption($category): array
    {
        $defaultOption = [
            'size' => ['width' => 1000, 'height' => 300],
            'watermark' => false,
            'changesize' => true,
            'dir' => 'img/categories/' . $category->id
        ];
        return $defaultOption;
    }


    public function index(Request $request)
    {

//        if (!Auth::user()->can('read-category')) {
//            return back()->with('error-message', 'دسترسی شما به این بخش محدود می باشد!');
//        }
        $parent_category= null;

        if ($request->has('category_id')) {

            $parent_category= Category::findOrFail($request->category_id) ;
            $query = Category::where('category_id',$request->category_id);
            $query->latest('position');

            $datatable = new CategoryDataTable($query);

            return $datatable->render('panel.category.index',compact('parent_category'));
        }

        $query = Category::whereDoesntHave('category');
        $query->latest('position');

        $datatable = new CategoryDataTable($query, 1);
        return $datatable->render('panel.category.index');
    }

    public function store(Request $request)
    {
//        if (!Auth::user()->can('create-category')) {
//            return back()->with('error-message', 'دسترسی شما به این بخش محدود می باشد!');
//        }
//
        $request->validate([
            'name' => ['required', 'string', 'min:4', 'max:254'],
            'icon' => ['required', 'string', 'min:4', 'max:254'],
            'slug' => ['nullable','string', 'min:4', 'max:254', 'unique:categories,slug'],
            'is_menu' => ['nullable', 'integer'],
            'category_id' => ['nullable', 'integer','exists:categories,id'],
        ]);

//        dd($request->all());
        DB::beginTransaction();
        try {
            $category = Category::create($request->all());

            if ($request->slug)
                $category->slug = sprintf('%s-%s', $category->id, str_slug_persian($request->slug));
            else
                $category->slug = sprintf('%s-%s', $category->id, str_slug_persian($category->name));

            $category->parents_array = $category->category ? $category->category->parents_array . $category->id . "-" : "-" . $category->id . "-";
            $category->lvl = $category->category ? $category->category->lvl + 1 : 0;
            $category->save();
            $this->saveImage($request, $category);

            return JsonResponse::sendJsonResponse(1, 'موفق', sprintf('دسته بندی  %s  با موفقیت روز رسانی گردید', $category->name),
                'DATATABLE_REFRESH');
        } catch (\Throwable $e) {
            DB::rollback();
        }


        return JsonResponse::sendJsonResponse(0, 'موفق', 'مشکلی یپش آمده',
            'REFRESH');

    }


    public function update(Request $request, Category $category)
    {
//        dd($request->all());
//        if (!Auth::user()->can('update-category')) {
//            return back()->with('error-message', 'دسترسی شما به این بخش محدود می باشد!');
//        }
        $request->validate([
            'name' => ['required','min:2','max:256'],
            'slug' => ['nullable','string', 'min:2', 'max:254', 'unique:categories,slug,'.$category->id],
            'is_menu' => ['nullable', 'integer'],
            'category_id' => ['nullable', 'integer','max:0'],
        ]);

        $category->update($request->all());

        if ($request->slug)
            $category->slug = sprintf('%s-%s', $category->id, str_slug_persian($request->slug));
        else
            $category->slug = sprintf('%s-%s', $category->id, str_slug_persian($category->name));

        $category->save();

        //update user image
        $this->saveImage($request, $category);

        return JsonResponse::sendJsonResponse(1, 'موفق', sprintf('دسته بندی  %s  با موفقیت روز رسانی گردید', $category->name),
            'DATATABLE_REFRESH');

    }


    public function activeToggle(Request $request, Category $category)
    {

//        if (!Auth::user()->can('update-category')) {
//            return back()->with('error-message', 'دسترسی شما به این بخش محدود می باشد!');
//        }

        $subcategory_count = $category->categories->count();
        if ($subcategory_count) {
             return response()->json(['message' =>  sprintf('دسته دارای %s  زیر مجموعه می باشد)', $subcategory_count), 'active' => $category->active]);

        }

        $takhfifs_count = $category->takhfifs->count();
        if ($takhfifs_count) {
            return response()->json(['message' =>  sprintf('دسته دارای %s  زیر محصول می باشد)', $takhfifs_count), 'active' => $category->active]);

        }

        $category->active = !$category->active;
        $category->save();
       return response()->json(['message' => 'با موفقیت ذخیره شد .', 'active' => $category->active]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category $category
     * @throws \Exception
     */
    public function destroy(Category $category)
    {
//        if (!Auth::user()->can('delete-category')) {
//            return back()->with('error-message', 'دسترسی شما به این بخش محدود می باشد!');
//        }

        $subcategory_count = $category->categories->count();
        if ($subcategory_count) {
            return back()->with('alert-message', sprintf('دسته دارای %s  زیر محجموعه می باشد)', $subcategory_count));
        }

        $products_count = $category->takhfifs->count();
        if ($products_count) {
            return back()->with('alert-message', sprintf('دسته دارای %s  زیر محصول می باشد)', $products_count));
        }

        $path = $category->image;
        $category->delete();
        //remove image
        if ($path) Image::removeImage($path);

        return  JsonResponse::sendJsonResponse(1, 'موفق', sprintf('دسته  %s  با موفقیت حذف گردید', $category->name), 'REFRESH');


    }

    /**
     * @param Request $request
     * @param Category $category
     */
    public function saveImage(Request $request, Category $category): void
    {
        $defaultOption = $this->setDefaultOption($category);

        $file = $request->file('main_image');
        if ($file) {
            try {
                $path = $category->image->path;
                $upload = upload_image($file, $defaultOption);
                $imageName = $upload[0];
                $thumbnail = $upload[1];
              //remove old image
                if ($path !== Image::NO_IMAGE_PATH) {
                    $category->image()->delete();
                    Image::removeImage($path);
                }
                $category->image()->create([
                    'path' => $imageName,
                    'thumbnail' => $thumbnail,
                    'title' => $category->name
                ]);

            } catch (\Exception $e) {
                Log::info($e);
            }
        }
    }
    public function removeImage($id)
    {
        //remove image
        //remove file
        $image = Image::findOrFail($id);
        $path = $image->path;
        $image->delete();
        if ($path) Image::removeImage($path);

    }
    public function ajaxEdit(Category $category)
    {
//        if (!Auth::user()->can('read-users')) {
////            return back()->with('error-message', 'دسترسی شما به این بخش محدود می باشد!');
//            return response()->json(['message'=>'عدم دسترسی کافی'],419);
//        }

        return view('panel.category.category-edit', compact('category'))->render();
    }

    public function ajaxSync(Category $category)
    {
        $attributes = Attribute::all();
        return view('panel.category.attributes', compact('category','attributes'))->render();
    }

    public function attributesUpdate(Request $request, $category)
    {
        $category = Category::with('attributes')->findOrFail($category);
//        dd($category);
        $category->attributes()->sync($request->attribute_id);

        return JsonResponse::sendJsonResponse(1, 'موفق', sprintf('دسته بندی  %s  با موفقیت روز رسانی گردید', $category->name),
            'DATATABLE_REFRESH');    }

}
