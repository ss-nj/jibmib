<?php

namespace App\Http\Core\Models\Banner;

use App\Http\Commerce\Models\Category;
use App\Http\Commerce\Models\Place;
use App\Traits\Imagable;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    //
    use Imagable;

    const BANNER_MAP = [
        'TOP_PAGE' => ['title' => 'نوار بالای صفحه ی','dimension' =>  '1280*70', 'position' => 'ALL'],
        'FOOTER' => ['title' => 'نوار فوتر', 'dimension' => '800*800', '1280*70',  'position' =>'ALL'],
        'POP_UP' => ['title' => 'پاپ آپ صفحه ی اول','dimension' =>  '800*800',  'position' =>'FIRST_page'],
        'PRODUCT_PAGE' => ['title' => 'بنر صفحه ی محصول', 'dimension' => '1280*200',  'position' =>'PRODUCT_PAGE'],
        'FIRST_PAGE_1' => ['title' => 'بنر بین قطعات صفحه اول 1', 'dimension' => '1280*200', 'position' => 'FIRST_PAGE_1'],
        'FIRST_PAGE_2' => ['title' => 'بنر بین قطعات صفحه اول 2', 'dimension' => '1280*200',  'position' =>'FIRST_PAGE_2'],
        'FIRST_PAGE_3' => ['title' => 'بنر بین قطعات صفحه اول 3', 'dimension' => '1280*200', 'position' => 'FIRST_PAGE_3'],
        'FIRST_PAGE_4' => ['title' => 'بنر بین قطعات صفحه اول 4', 'dimension' => '1280*200', 'position' => 'FIRST_PAGE_4'],
        'FIRST_PAGE_5' => ['title' => 'بنر بین قطعات صفحه اول 5', 'dimension' => '1280*200', 'position' => 'FIRST_PAGE_5'],
        'CATEGORIES_1' => ['title' => 'بنر بین قطعات دسته بندی 1', 'dimension' => '1280*200', 'position' => 'CATEGORIES_1'],
        'CATEGORIES_2' => ['title' => 'بنر بین قطعات دسته بندی 2', 'dimension' => '1280*200', 'position' => 'CATEGORIES_2'],
        'CATEGORIES_3' => ['title' => 'بنر بین قطعات دسته بندی 3', 'dimension' => '1280*200', 'position' => 'CATEGORIES_3'],
        'CATEGORIES_4' => ['title' => 'بنر بین قطعات دسته بندی 4', 'dimension' => '1280*200', 'position' => 'CATEGORIES_4'],

    ];

    protected $fillable = [
        'banner_position',
        'title',
        'category_id',
        'place_id',
        'banners_url',
        'expires_date',
        'start_date',
        'active',
        'type',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'expires_date' => 'datetime',
        'start_date' => 'datetime',
        'active' => 'boolean',
    ];



    public function scopeActive($query)
    {
        return $query;
        return $query->where('active', 1)->where('start_date', '<=', now())->where('expires_date', '>=', now());
    }


    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function place()
    {
        return $this->belongsTo(Place::class);
    }

}
