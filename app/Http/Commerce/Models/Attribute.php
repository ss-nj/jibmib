<?php

namespace App\Http\Commerce\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Rutorika\Sortable\SortableTrait;

class Attribute extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SortableTrait;

    protected $fillable = [
        'title',
        'multiple',
        'description',
        'position',
        'field_type',
        'validation_unit',
        'validation_length',
        'active',
    ];

    const TYPE_MAP = [
        'number' => 'عدد',
        'short-text' => 'متن کوتاه',
        'long-text' => 'متن طولانی',
//        'file' => 'فایل',
//        'date' => 'تاریخ',
        'single-choice' => 'انتخاب تکی',
        'single-choice-select-box' => 'انتخاب تکی کشویی',
        'multi-choice' => 'انتخاب چندتایی',

    ];

    public function getTypeAttribute()
    {
        return $this->TYPE_MAP[$this->field_type];

    }


    public function values()
    {
        return $this->hasMany(AttributeValue::class);
    }

}
