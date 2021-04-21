<?php

namespace App\Http\Shop\Models;

use App\Http\Commerce\Models\Category;
use App\Http\Commerce\Models\Uploads;
use App\Http\Commerce\Models\Violation;
use App\Http\Core\Models\City;
use App\Http\Core\Models\Image;
use App\Http\Core\Models\Province;
use App\Http\Core\Models\User;
use App\OrderItem;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{

    use HasFactory;

    protected $fillable = [

        'user_id',
        'is_for',
        'amount',
        'meta',
        'payment_date',
        'cardNumber',
        'track_code',
        'ref_id',
        'status',//2 onprogress 1 approved 0 not success or canceled
        'pay_way',
        'ip',

    ];
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'meta' => 'array',
    ];

    /* The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'status_text'
    ];
    /*
|--------------------------------------------------------------------------
| ATRIBUTES
|--------------------------------------------------------------------------
*/

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function orders()
    {
        return $this->hasMany(OrderItem::class, 'transaction_id');
    }

    public function getStatusTextAttribute()
    {

        return $this->payment_date ? ($this->status == 1 ? 'پرداخت شده' : 'ناموفق1') : ( now()->diffInMinutes($this->created_at) > 20
            ? 'ناموفق' : 'هدایت شده به بانک');
    }

//    public function getMetaAttribute($meta)
//    {
//        return join(', ', json_decode($meta));
//    }
//
//
//    public function getMetaArrayAttribute()
//    {
//        return json_decode($this->attributes['meta']);
//    }
//
//    public function setMetaAttribute($meta)
//    {
//        $this->attributes['meta'] = json_encode(array_map('trim',
//            explode(',', $meta)));
//    }
}
