<?php

namespace App\Http\Commerce\Controllers;

use App\Http\Commerce\Models\Attribute;
use App\Http\Commerce\Models\AttributeValue;
use App\Http\Controllers\Controller;
use App\Support\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AttributeValueController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index($attribute)
    {
        $attribute = Attribute::findOrFail($attribute);
        $values = AttributeValue::where('attribute_id', $attribute->id)->orderBy('position')->paginate('40');
        return view('panel.attribute-value.index', compact('attribute', 'values'));
    }


    /**
     * @param Request $request
     */
    public function store(Request $request)
    {
        $request->validate([
            'value' => ['required', 'unique:attribute_values','min:1'],
            'attribute_id' => 'required'
        ]);

      $value=  AttributeValue::create([
            'attribute_id' => $request->attribute_id,
            'value' => $request->value
        ]);

        return JsonResponse::sendJsonResponse(1, 'موفق', sprintf('مقدار ویژگی  %s  با موفقیت ایجاد گردید', $value->name),
            'REFRESH');
    }


    /**
     * @param AttributeValue $attributeValue
     * @throws \Exception
     */
    public function destroy( $attributeValue)
    {
        $attributeValue = AttributeValue::findOrFail($attributeValue);

        $attributeValue->delete();

        return JsonResponse::sendJsonResponse(1, 'موفق', 'با موفقیت حذف شد',
            'REFRESH');
    }
}
