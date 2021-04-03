<?php

namespace App\Http\Shop\Models;

use App\Http\Core\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
     public function takhfif()
    {
        return $this->belongsTo(Takhfif::class);
    }


}
