<?php

namespace App\Http\Core\Models;

use App\Http\Commerce\Models\Category;
use App\Http\Shop\Models\Takhfif;
use App\Traits\Imagable;
use Illuminate\Database\Eloquent\Model;
use Rutorika\Sortable\SortableTrait;

class Menu extends Model
{
    use SortableTrait;
    use Imagable;

    public const LINK = 0;
    public const CATEGORY = 1;
    public const TAKHFIF = 2;

    const MENU_MAP = [
        'header' => 'هدر سایت',
        'footer_1' => 'فوتر سایت 1',
        'footer_2' => 'فوتر سایت 2',
        'footer_3' => 'فوتر سایت 3',
        'footer_4' => 'فوتر سایت 4',
        'sticky' => 'منوی شناور',

    ];
    protected $fillable = ['id',
        'menu',
        'name',
        'slug',
        'link',
//        'position',
        'type',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];
    //
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
    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    /*
	|--------------------------------------------------------------------------
	| RELATIONS
	|--------------------------------------------------------------------------
	*/

    public function takhfifs()
    {
        return $this->belongsTo(Takhfif::class);
    }


    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_menu'
            , 'menu_id', 'category_id')
            ->withTimestamps();
    }

}
