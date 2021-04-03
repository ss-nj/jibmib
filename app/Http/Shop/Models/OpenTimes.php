<?php

namespace App\Http\Shop\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpenTimes extends Model
{
    use HasFactory;
    protected $fillable = [
        'start_time',
        'end_time',
        'week_day',
    ];

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
}
