<?php

namespace App\Http\Shop\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TakhfifAttributeValues extends Model
{
    use HasFactory;

    protected $fillable=['attribute_id','advertising_id','value','attribute_value_id'];

    public function attribute()
    {
        return $this->belongsTo(Attribute::class,'attribute_id');
    }

    public function takhfif()
    {
        return $this->belongsTo(Takhfif::class,'advertising_id');
    }



}
