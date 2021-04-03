<?php

namespace App\Http\Shop\Models;

use App\Http\Commerce\Models\Category;
use App\Http\Commerce\Models\Uploads;
use App\Http\Commerce\Models\Violation;
use App\Http\Core\Models\City;
use App\Http\Core\Models\Image;
use App\Http\Core\Models\Province;
use App\Http\Core\Models\User;
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
        'track_code',
        'ref_id',
        'status',
        'pay_way',
        'ip',

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
}
