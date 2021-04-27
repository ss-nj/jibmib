<?php

namespace App\Http\Shop\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Wallet extends Model  implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
//        'shop_id',
        'amount',
    ];

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
}
