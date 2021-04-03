<?php

namespace App\Http\Core\Models;

use App\Basket;
use App\Traits\Imagable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;
use OwenIt\Auditing\Contracts\Auditable;

class User extends Authenticatable implements Auditable
{
    use LaratrustUserTrait;
    use Notifiable;
    use Imagable;
    use \OwenIt\Auditing\Auditable;

    public const MAN = 0;
    public const woman = 1;
    public const OTHER = 2;

    public function generateTags(): array
    {
        return [
            $this->name,
            $this->mobile,
        ];
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['wallet', 'parent_id',
        'first_name', 'last_name','mobile', 'email','address','email',
'city_id','province_id',
        'mobile_verified_at', 'active',
        'affiliate_code',
        'password',
        'mobile_verified_at', 'verify_mobile_code',

    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'mobile_verified_at' => 'datetime',
        'active' => 'boolean',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'full_name'
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
    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    /*
	|--------------------------------------------------------------------------
	| ATRIBUTES
	|--------------------------------------------------------------------------
	*/

    public function getFullNameAttribute()
    {
        return trim("{$this->first_name} {$this->last_name}");
    }


    /*
        |--------------------------------------------------------------------------
        | RELATIONS
        |--------------------------------------------------------------------------
        */
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }


    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }


    public function parent()
    {

        return $this->belongsTo(__CLASS__, 'parent_id');
    }

    public function child()
    {

        return $this->hasMany(__CLASS__, 'parent_id');
    }

    public function baskets()
    {
        return $this->hasMany(Basket::class);
    }
}
