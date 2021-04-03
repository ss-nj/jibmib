<?php

namespace App\Http\Core\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    public $table = 'provinces';
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
    public function cities()
    {
        return $this->hasMany(City::class);
    }
}
