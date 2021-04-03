<?php

namespace App\Http\Shop\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Rutorika\Sortable\SortableTrait;

class Refund extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    use SortableTrait;

    protected $fillable = [
//        'shop_id',
        'amount',
//        'bank_id',
        'description',
//        'approve_date',
//        'pay_date',
//        'by_admin',
    ];

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }


}
