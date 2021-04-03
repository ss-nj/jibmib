<?php

namespace App\Http\Core\Models;
use App\Http\Commerce\Models\Category;
use App\Http\Commerce\Models\Place;
use App\Http\Shop\Models\Takhfif;
use App\Traits\Imagable;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Rutorika\Sortable\SortableTrait;

class Slider extends Model  implements Auditable
{
    use Imagable;
    use \OwenIt\Auditing\Auditable;
    use SortableTrait;

//    CONST POSITIONS_MAP=[
//        'HOME'=>''
//    ];

    protected $fillable = [
        'name',
        'place_id',
        'category_id',
        'takhfif_id',
        'button_text',
        'button_link',
        'start_time',
        'expire_time',
        'position',
        'active',
    ];
 /*
	|--------------------------------------------------------------------------
	| EVENTS
	|--------------------------------------------------------------------------
	*/


    /*
	|--------------------------------------------------------------------------
	| FUNCTIONS
	|--------------------------------------------------------------------------
	*/

    /*
	|--------------------------------------------------------------------------
	| RELATIONS
	|--------------------------------------------------------------------------
	*/

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function takhfif()
    {
        return $this->belongsTo(Takhfif::class, 'takhfif_id');
    }

    public function city()
    {
        return $this->belongsTo(Place::class, 'place_id');
    }

}
