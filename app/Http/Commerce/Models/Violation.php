<?php

namespace App\Http\Commerce\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Violation
 * @package App
 * ثبت تخلفات کوپن ها
 */
class Violation extends Model
{
    use HasFactory;
    protected $fillable =[
        'user_id',
        'takhfif_id',
        'title',
        'description',
    ];
}
