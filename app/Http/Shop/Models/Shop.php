<?php

namespace App\Http\Shop\Models;

use App\Http\Commerce\Models\Category;
use App\Http\Commerce\Models\Uploads;
use App\Http\Commerce\Models\Violation;
use App\Http\Core\Models\City;
use App\Http\Core\Models\Image;
use App\Http\Core\Models\Province;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{

    use HasFactory;

    protected $fillable = [
//        'owner_name',
//        'shop_name',
//        'slug',
        'category_id',
        'lat',
        'lang',
        'province_id',
        'city_id',
        'address',
        'place_id',
        'description',
//        'phone',//for login
        'uuid',
        'isbn',
        'bank_id',
        'bank_account_owner_name',
        'bank_account_owner_last_name',
        'bank_account_type',
//        'service_time',
//        'service_week_days',
//        'approved',
//        'active',

    ];
    protected $casts = [
        'active' => 'boolean',

    ];
/* The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'full_address'
    ];

    /*
|--------------------------------------------------------------------------
| ATRIBUTES
|--------------------------------------------------------------------------
*/

    public function getFullAddressAttribute()
    {
       $a= ($this->province ?
               $this->province->name : '')
           . '-' . ($this->city ? $this->city->name : '')
           . '-' . ($this->address);
        return $a;
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function province()
    {
        return $this->belongsTo(Province::class);

    }

    //images relation
    protected $morphClass = null;

    public function getMorphClass()
    {
        return $this->morphClass ?: static::class;
    }

    public function logo()
    {
        $this->morphClass = 'ShopLogo';

        return $this->morphOne(Image::class, 'imagable')
            ->withDefault(['path' => Image::NO_IMAGE_PATH, 'thumbnail' => Image::NO_IMAGE_PATH]);
    }

    public function images()
    {
        $this->morphClass = 'ShopImage';
        return $this->morphMany(Image::class, 'imagable');
    }

    public function licences()
    {
        $this->morphClass = 'ShopLicences';
        return $this->morphMany(Image::class, 'imagable');
    }


    public function phones()
    {
        return $this->hasMany(Phone::class);
    }


    public function licence()
    {
        return $this->hasOne(Uploads::class, 'shop_id')->where('type', 'licence')->latest();
    }

    public function userid()
    {
        return $this->hasOne(Uploads::class, 'shop_id')->where('type', 'userid')->latest();
    }

    public function times()
    {
        return $this->hasMany(OpenTimes::class, 'shop_id');
    }

    public function violations()
    {
        return $this->hasMany(Violation::class);
    }

    public function takhfifs()
    {
        return $this->hasMany(Takhfif::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function disapprove()
    {
        return $this->hasOne(Disapproves::class, 'shop_id')->latest();

    }
    public function disapproves()
    {
        return $this->hasMany(Disapproves::class);

    }
    public function refunds()
    {
        return $this->hasMany(Refund::class);

    }

    public function wallet()
    {
        return $this->hasone(Wallet::class,'shop_id');
    }
}
