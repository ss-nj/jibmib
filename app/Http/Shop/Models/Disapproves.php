<?php

namespace App\Http\Shop\Models;

use App\Http\Core\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disapproves extends Model
{
    use HasFactory;

//
    protected $fillable = [
//        'shop_id',
//        'takhfif_id',
        'reason',
//        'admin_id',
    ];

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class,'admin_id');
    }

    public function takhfifs()
    {
        return $this->belongsTo(Takhfif::class);
    }
}
