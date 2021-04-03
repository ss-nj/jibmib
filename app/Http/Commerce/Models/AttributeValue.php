<?php

namespace App\Http\Commerce\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Rutorika\Sortable\SortableTrait;

class AttributeValue extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use SortableTrait;
    public $table = 'attribute_values';

    protected $fillable = [
        'attribute_id',
        'value',
        'position',
    ];

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }
}
