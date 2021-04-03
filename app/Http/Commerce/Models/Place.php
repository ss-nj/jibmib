<?php

namespace App\Http\Commerce\Models;

use App\Http\Core\Models\City;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Rutorika\Sortable\SortableTrait;

class Place extends Model
{
    use HasFactory;
    use SortableTrait;

    protected $fillable=[
        'city_id',
        'name',
        'slug',
        'active',
        'position',
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
