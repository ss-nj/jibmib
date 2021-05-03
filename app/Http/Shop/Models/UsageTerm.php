<?php

namespace App\Http\Shop\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsageTerm extends Model
{
    use HasFactory;

    protected $fillable = [
        'value',

    ];

    public function takhfif()
    {
        return $this->belongsTo(Takhfif::class);
    }
}
