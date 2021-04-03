<?php

namespace App\Http\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Image extends Model
{
    //

    public const NO_IMAGE_PATH = 'assets/no_image.jpg';

    protected $fillable = [
        'path',
        'thumbnail',
        'title',
        'description',
        'imagable_type', 'imagable_id',
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
    public function image()
    {
        return $this->morphTo();
    }

    public function imagable()
    {
        return $this->morphTo();
    }

    /**
     * @param $path
     */
    public static function removeImage($path): void
    {
        try {
            if ($path && $path!='assets/no_image.jpg') remove_file($path);
        } catch (\Exception $exception) {
            Log::info($exception);
        }
    }
}
