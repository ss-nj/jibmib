<?php

namespace App\Http\Commerce\Models;

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
}
