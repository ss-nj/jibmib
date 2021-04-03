<?php

namespace App\Http\Core\Models\Banner;

use Illuminate\Database\Eloquent\Model;

class BannerHistory extends Model
{
    //
    protected $fillable = [
        'banners_history_id',
        'banners_id',
        'banners_shown',
        'banners_clicked',
        'banners_history_date',
    ];

     /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'end_at' => 'datetime',
        'active' => 'boolean',
    ];

    public function Banner()
    {
        return $this->belongsTo(Banner::class);
}
}
