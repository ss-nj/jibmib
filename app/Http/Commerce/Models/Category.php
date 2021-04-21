<?php

namespace App\Http\Commerce\Models;

use App\Http\Shop\Models\Takhfif;
use App\Traits\Imagable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Rutorika\Sortable\SortableTrait;

class Category extends Model
{
    use HasFactory;
    use  Imagable;
    use SortableTrait;

    protected $fillable = [
        'name',
        'slug',
        'category_id',
        'parents_array',
        'lvl',
        'position',
        'is_menu',
        'active',
        'icon',
    ];

    protected $casts = ['is_menu' => 'boolean'];

    public function takhfifs()
    {
        return $this->belongsToMany(Takhfif::class, 'category_takhfif');
    }

    public function attributes()
    {
//        return $this->belongsToMany(Attribute::class, 'attribute_categories', 'category_id', 'attribute_id');
        return $this->belongsToMany(Attribute::class, 'attribute_categories', 'category_id', 'attribute_id');

    }

//    public function attributes()
//    {
//        return $this->belongsToMany(Attribute::class, 'attribute_categories', 'category_id', 'attribute_id')->with('values');
//
//    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function categories()
    {
        return $this->hasMany(Category::class, 'category_id');
    }

    public function getDiscountAttribute()
    {
        $discount = 0;
        foreach ($this->takhfifs as $takhfif)
        {
            $discount = max($discount,$takhfif->discount);
        }
        return  round($discount,0) ;

    }
}
