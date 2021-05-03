<?php

namespace App\Http\Commerce\Models;

use App\Http\Shop\Models\Shop;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Uploads extends Model
{

    protected $fillable=[
        'type',
        'reason',
        'admin_id',
        'src',
        'approved',
    ];

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
}
