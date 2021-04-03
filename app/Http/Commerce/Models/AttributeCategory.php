<?php

namespace App\Http\Commerce\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class AttributeCategory extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'attribute_id',
        'category_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class,'category_id','id');
    }

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }

}
