<?php

namespace App;

use App\Http\Core\Models\User;
use App\Http\Shop\Models\Takhfif;
use App\Http\Shop\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    /* The accessors to append to the model's array form.
         *
         * @var array
         */
    protected $appends = [
        'status_text'
    ];
    protected $casts = [
        'status' => 'boolean',

    ];

    protected $fillable = [
        'takhfif_id',
        'user_id',
        'takhfif_name',
        'transaction_id',
        'code',
        'takhfif_price',
        'takhfif_discount',
        'takhfif_count',
        'revoke_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function takhfif()
    {
        return $this->belongsTo(Takhfif::class,'takhfif_id');
    }

 public function transaction()
    {
        return $this->belongsTo(Transaction::class,'transaction_id');
    }


    public function getStatusTextAttribute()
    {
        $statusMap = [
            0=>'فعال',
            1=> 'استفاده شده',
            2=> 'غیر فعال',
        ];
        return $statusMap[$this->status];

    }




}
