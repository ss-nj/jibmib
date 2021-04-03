<?php

namespace App;

use App\Http\Core\Models\User;
use App\Http\Shop\Models\Takhfif;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Basket extends Model
{
    use HasFactory;

    protected $fillable = [
        'takhfif_id',
        'count',
        'price',
        'discount_price',
    ];

    public function takhfif()
    {
        return $this->belongsTo(Takhfif::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
