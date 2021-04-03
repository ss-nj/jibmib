<?php

namespace App\Http\Shop\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TakhfifFiles extends Model
{
    use HasFactory;

    protected $fillable=[
        'name',
        'reason',
        'src',
        'approved',
    ];
}
