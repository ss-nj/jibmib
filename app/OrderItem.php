<?php

namespace App;

use App\Http\Core\Models\User;
use App\Http\Shop\Models\Takhfif;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'takhfif_id',
        'takhfif_name',
        'transaction_id',
        'code',
        'takhfif_price',
        'takhfif_discount',
        'takhfif_count',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function takhfif()
    {
        return $this->belongsTo(Takhfif::class);
    }
}
