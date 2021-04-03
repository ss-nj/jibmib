<?php

namespace App\Http\Shop\Models;

use App\Http\Core\Models\User;
use App\Http\Shop\Models\Takhfif;
use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{

    public function user()
    {
        $this->belongsTo(User::class,'user_id');
    }

    public function takhfif()
    {
        $this->belongsTo(Takhfif::class, 'takhfif_id');
    }
}
