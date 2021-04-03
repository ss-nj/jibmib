<?php

namespace App\Traits;


use App\Http\Core\Models\Image;

/**
 * Trait Imagable
 * @package App\Traits
 */
trait Imagable
{
    //beware to dint delete default file
    public function image()
    {
        return $this->morphOne(Image::class, 'imagable')
            ->withDefault(['path' => Image::NO_IMAGE_PATH,'thumbnail' => Image::NO_IMAGE_PATH])
            ;
    }

}
