<?php

namespace App\Http\Commerce\Controllers;

use App\Http\Commerce\Models\AttributeCategory;
use App\Http\Commerce\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use function back;

class AttributeCategoryController extends Controller
{



    public function index(Request $request)
    {


    }

    public function store(Request $request)
    {
//        dd($request->all());
//        if (!Auth::user()->can('create-category')) {
//            return back()->with('error-message', 'دسترسی شما به این بخش محدود می باشد!');
//        }

        $request->validate([
            'subcategory_id' => 'required',
            'attribute_id' => 'required',
        ]);

        foreach ($request->category_id as $cat){
            $category = Category::find($cat);
            $category->attributes()->sync($request->attribute_id);
        }


        return back()->with('success-message','با موفقیت ثبت شد');

    }


    public function update(Request $request)
    {

        $request->validate([
            'attribute_id' => 'required|array',
            'category_id' => 'required'
        ]);

        $category = Category::find($request->category_id);

        $category->attributes()->sync($request->attribute_id);

        return back()->with('success-message','با موفقیت ویرایش شد');

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param AttributeCategory $attributeSubcategory
     * @return RedirectResponse
     */
    public function destroy(AttributeCategory $attributeSubcategory)
    {
//        dd($attributeSubcategory);
//        if (!Auth::user()->can('delete-category')) {
//            return back()->with('error-message', 'دسترسی شما به این بخش محدود می باشد!');
//        }

        return back()->with('success-message', 'با موفقیت حذف شد');

    }
}
