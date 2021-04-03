<?php

namespace App\Http\Core\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    //
    public CONST STATUS = [
        0 => ['در حال بررسی', '#b2c326','ON_PROGRESS'],
        1 => ['جواب داده شده', '#0f0','ANSWERED'],
        2 => ['بسته شده', '#f00','CLOSED'],
    ];
    protected $fillable =['title','status'];
 /*
	|--------------------------------------------------------------------------
	| EVENTS
	|--------------------------------------------------------------------------
	*/


    /*
	|--------------------------------------------------------------------------
	| FUNCTIONS
	|--------------------------------------------------------------------------
	*/

    /*
	|--------------------------------------------------------------------------
	| RELATIONS
	|--------------------------------------------------------------------------
	*/
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function latestMessage()
    {
        return $this->hasOne(Message::class)->latest();
    }


}
