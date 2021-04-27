<?php

namespace App\Http\Core\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable =['body','from_admin'];
 /*
	|--------------------------------------------------------------------------
	| EVENTS
	|--------------------------------------------------------------------------
	*/

    public $casts=[
         'from_admin' => 'boolean',
    ];
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
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
