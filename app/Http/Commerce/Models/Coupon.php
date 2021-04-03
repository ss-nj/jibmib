<?php

namespace App\Http\Commerce\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Coupon extends Model   implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    public CONST CATEGORIES=1;
    public CONST TAKHFIFS=2;
    public CONST ALL=0;
    const PERCENT = 0;
    const AMOUNT = 1;
    protected $fillable = [

        'name',
        'code',
        'limit_on_discount',
        'limit_on_cart',
        'percent',
        'amount',
        'active',
        'start_time',
        'expire_time',
        'type',
        'description',
        'effect_zone',
        'count'

    ];

    protected $dates = ['start_time', 'end_time'];

    protected $casts = [
        'active','effect_zone','type' => 'boolean',

    ];

}
