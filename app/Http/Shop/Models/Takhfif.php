<?php

namespace App\Http\Shop\Models;

use App\Http\Commerce\Models\Category;
use App\Http\Core\Models\Comment;
use App\Http\Core\Models\User;
use App\Http\Core\Models\Image;
use Illuminate\Database\Eloquent\Model;
use PayPal\Api\Transactions;

class Takhfif extends Model  implements \OwenIt\Auditing\Contracts\Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'tags',
        'name',
//        'slug',
        'display_start_time',
        'display_end_time',
        'usage_start_time',
        'usage_expire_time',
        'time_out',
        'capacity',
//        'vip',
//        'shop_id',
        'description',
//        'active',
//        'view_count',
//        'approved',
        'price',
//        'discount',
        'discount_price',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'display_start_time' => 'datetime',
        'display_end_time' => 'datetime',
        'start_time' => 'datetime',
        'expire_time' => 'datetime',
        'active' => 'boolean',
        'vip' => 'boolean',
    ];


    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imagable');
    }

    public function getImageFirstAttribute()
    {
        return $this->images()->count() ? $this->images()->first()->path : Image::NO_IMAGE_PATH;
    }


//    public function image()
//    {
//        return Image::where('imagable_type','App\Http\Shop\Models\Takhfif')
//            ->where('imagable_id',$this->id);
//    }

//    public function files()
//    {
//        return $this->hasMany(Uploads::class);
//    }

    public function rates()
    {
        return $this->hasMany(Rate::class);
    }

    public function favorite()
    {
        return $this->hasMany(Favorite::class);
    }

    public function favorite_user()
    {
        return $this->belongsToMany(User::class, 'favorites');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_takhfif');
    }

    public function disapproves()
    {
        return $this->hasMany(Disapproves::class, 'takhfif_id');
    }

    public function disapprove()
    {
        return $this->hasOne(Disapproves::class, 'takhfif_id')->latest();

    }


    public function transactions()
    {
        return $this->hasMany(Transactions::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class,'commentable_id')->where('commentable_type','App\Http\Shop\Models\Takhfif');
    }

    //ویژگی
    public function parameters()
    {
        return $this->hasMany(Parameter::class);
    }

    //پرسش و پاسخ
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    //شرایط استفاده
    public function terms()
    {
        return $this->hasMany(UsageTerm::class);
    }

    public function getDiscountAttribute()
    {
        if (!$this->price)
            return 0;
        $discount = ((($this->price - $this->discount_price) / $this->price) * 100);
        return $discount > 0 ? $discount : 0;
    }

    public function getUsageTimeOutAttribute()
    {
        if (!$this->usage_start_time ||
            !$this->usage_expire_time ||
            ($this->usage_start_time <= $this->usage_expire_time) ||
            (now() >= $this->usage_expire_time)
        )
            return 0;

        $usage_time_out = now() - $this->usage_expire_time;
        return $usage_time_out > 0 ? $usage_time_out : 0;
    }
}
