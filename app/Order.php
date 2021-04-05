<?php

namespace App;

use App\Http\Core\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
///        'user_id',
        'transaction_id',
        'discount_code',
        'total_price',
        'total_discount',
        'card_number',
        'track_code',
        'admin_seen',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
