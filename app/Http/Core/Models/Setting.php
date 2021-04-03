<?php

namespace App\Http\Core\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Setting extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
//    'register_red_path','login_redirect_path','login_admin_redirect_path'
    public const MAP_REG_REDIRECTS = [
        '0' => 'home',
        '1' => 'profile',
        '2' => 'cart',
        '3' => 'user.dashboard',
    ];

    public const MAP_LOGIN_REDIRECTS = [
        '0' => 'home',
        '1' => 'profile',
        '2' => 'cart',
        '3' => 'user.dashboard',
    ];

    public const MAP_ADMIN_LOGIN_REDIRECTS = [
        '0' => 'home',
        '1' => 'profile',
        '2' => 'cart',
        '3' => 'user.dashboard',
        '4' => 'panel.dashboard',
     ];





    //
    protected $fillable = [
        'key',
        'label',
        'value_fa',
        'value_en',
        'type',
        'setting_group',
        'length_limit',
    ];
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
}
