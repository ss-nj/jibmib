<?php

use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;

/*
|--------------------------------------------------------------------------
| Custom Helper file
|--------------------------------------------------------------------------
|
*/


/////generate random str i removed confusing  chars ike li o0
if (!function_exists('rand_str')) {
    function rand_str(int $length)
    {
        return substr(str_shuffle(str_repeat("23456789abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTU", $length)), 0, $length); //str_random(4);//random_int(100000, 999999);
    }
}
/////Upload_file
if (!function_exists('upload_image')) {
    function upload_image(object $file, array $option = [])
    {
        //Set Default Option
        $defaultOption = [
            'format' => null,
            'size' => ['width' => 800, 'height' => 800],
            'watermark' => true,
            'changesize' => true,
            'watermarkurl' => 'img/logo.png',
            'filename' => uniqid() . '.' . $file->getClientOriginalExtension(),
            'dir' => today()->format('Ymd')
        ];

        //Merge Option Argument with Default Option
        $option = array_merge($defaultOption, $option);
        //Upload file to Server
        $imgaddress = $file->move($option['dir'], $option['filename'])->getpathname();
        //Open Image Editor
        $img = Image::make($imgaddress);
        //Resize Image
        if ($option['changesize'])
            $img->fit($option['size']['width'], $option['size']['height']);
//        $img->resize($option['size']['width'], $option['size']['height'],
//            function ($constraint) {
//                $constraint->aspectRatio();
//            });
        //Add Water Mark
        if ($option['watermark'])
            $img->insert($option['watermarkurl'],'bottom-left', 5, 5);

        //Save Replace Edited image
        if ($option['format'])
            $img->save($imgaddress, $option['format']);
        else
            $img->save($imgaddress, 70, 'jpg');

//save thumbnail
        $imgaddress2 = $option['dir'] . 'thumb-' . $option['filename'];
//        $img->save($imgaddress2, 70, 'jpg');
        $img->fit(200, 200)->save($imgaddress2, 70, 'jpg');
        return [str_replace('\\', '/', $imgaddress), str_replace('\\', '/', $imgaddress2)];


    }
}
/////remove file
if (!function_exists('remove_file')) {
//    dd(1);

    function remove_file(string $file)
    {
        //Check Exist file
        if (file_exists(public_path($file)))
            return unlink(public_path($file));//Remove File
        else
            return false;

    }
}

/////Generate Random Password
if (!function_exists('password_generator')) {
    function password_generator(int $length = 10, bool $hash = false)
    {
        //Specified Password Chars and Shuffle it
        $chars = str_shuffle('abcdefghjklmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ1234567890!$%^&!$%^&');
        //define password length
        $password = substr($chars, 0, $length);
        //Return Hash or simple Password
        return ($hash ? Hash::make($password) : $password);

    }
}
/////Passed time in string
if (!function_exists('passed_time')) {
    function passed_time(int $diff = 1)
    {
        //Set Time one if its zero
        $diff = ($diff < 1) ? 1 : $diff;
        //Define Names
        $times = [
            31536000 => trans('definitions.year'),
            2592000 => trans('definitions.month'),
            604800 => trans('definitions.week'),
            86400 => trans('definitions.day'),
            3600 => trans('definitions.hour'),
            60 => trans('definitions.minute'),
            1 => trans('definitions.second')
        ];
        //find the unit and count
        foreach ($times as $second => $unit) {
            if ($diff < $second) continue;//Continue to next
            $passedtime = [
                'unit' => $unit,
                'count' => floor($diff / $second),
            ];
            break;
        }
        //Set Definitions
        switch ($passedtime['unit']) {
            case trans('definitions.second'):
                $passedtime = trans('definitions.sometime');
                break;
            case trans('definitions.minute'):
                if ($passedtime['count'] < 15)
                    $passedtime = trans('definitions.someminutes');
                elseif ($passedtime['count'] < 20)
                    $passedtime = trans('definitions.aquarter');
                else
                    $passedtime = trans('definitions.halfhour');
                break;
            case trans('definitions.day'):
                if ($passedtime['count'] = 1)
                    $passedtime = trans('definitions.yesterday');
                elseif ($passedtime['count'] = 2)
                    $passedtime = trans('definitions.twodaysago');
                break;

            default:
                $passedtime = $passedtime['count'] . $passedtime['unit'] . trans('definitions.ago');
                break;


        }
        return $passedtime;

    }

    if (!function_exists('fa_to_en')) {
        function fa_to_en($string)
        {
            $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
            $arabic = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];
            $english = range(0, 9);

            $convertedPersianDigits = str_replace($persian, $english, $string);
            return str_replace($arabic, $english, $convertedPersianDigits);
        }
    }

    if (!function_exists('en_to_fa')) {
        function en_to_fa($text)
        {
            $english = range(0, 9);
            $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
            $text = str_replace($english, $persian, $text);
            return $text;
        }
    }


    if (!function_exists('topersian')) {
        function topersian($text)
        {
            $arabic = array('ي', 'ك', '٤', '٥', '٦');
            $persian = array('ی', 'ک', '۴', '۵', '۶');
            $text = str_replace($arabic, $persian, $text);
            return $text;
        }
    }
}
//generate persian slug
if (!function_exists('str_slug_persian')) {
    /**
     * Generate a URL friendly "slug" from a given string.
     *
     * @param string $title
     * @param string $separator
     * @return string
     */
    function str_slug_persian($title, $separator = '-')
    {
        $title = trim($title);
        $title = mb_strtolower($title, 'UTF-8');

        $title = str_replace('‌', $separator, $title);

        $title = preg_replace(
            '/[^a-z0-9_\s\-اآبپتثجچحخدذرزژسشصضطظعغفقكکگلمنويهی۰۱۲۳۴۵۶۷۸۹٠١٢٣٤٥٦٧٨٩]/u',
            '',
            $title
        );

        $title = preg_replace('/[\s\-_]+/', $separator, $title);
        $title = preg_replace('/[\s_]/', $separator, $title);
        $title = trim($title, $separator);

        return $title;
    }
}
if (!function_exists('str_slug_persian2')) {
    /**
     * Generate a URL friendly "slug" from a given string.
     *
     * @param string $string
     * @param string $separator
     * @return string
     */
    function str_slug_persian2($string, $separator = '-')
    {
        $_transliteration = array(
            '/ä|æ|ǽ/' => 'ae',
            '/ö|œ/' => 'oe',
            '/ü/' => 'ue',
            '/Ä/' => 'Ae',
            '/Ü/' => 'Ue',
            '/Ö/' => 'Oe',
            '/À|Á|Â|Ã|Å|Ǻ|Ā|Ă|Ą|Ǎ/' => 'A',
            '/à|á|â|ã|å|ǻ|ā|ă|ą|ǎ|ª/' => 'a',
            '/Ç|Ć|Ĉ|Ċ|Č/' => 'C',
            '/ç|ć|ĉ|ċ|č/' => 'c',
            '/Ð|Ď|Đ/' => 'D',
            '/ð|ď|đ/' => 'd',
            '/È|É|Ê|Ë|Ē|Ĕ|Ė|Ę|Ě/' => 'E',
            '/è|é|ê|ë|ē|ĕ|ė|ę|ě/' => 'e',
            '/Ĝ|Ğ|Ġ|Ģ/' => 'G',
            '/ĝ|ğ|ġ|ģ/' => 'g',
            '/Ĥ|Ħ/' => 'H',
            '/ĥ|ħ/' => 'h',
            '/Ì|Í|Î|Ï|Ĩ|Ī|Ĭ|Ǐ|Į|İ/' => 'I',
            '/ì|í|î|ï|ĩ|ī|ĭ|ǐ|į|ı/' => 'i',
            '/Ĵ/' => 'J',
            '/ĵ/' => 'j',
            '/Ķ/' => 'K',
            '/ķ/' => 'k',
            '/Ĺ|Ļ|Ľ|Ŀ|Ł/' => 'L',
            '/ĺ|ļ|ľ|ŀ|ł/' => 'l',
            '/Ñ|Ń|Ņ|Ň/' => 'N',
            '/ñ|ń|ņ|ň|ŉ/' => 'n',
            '/Ò|Ó|Ô|Õ|Ō|Ŏ|Ǒ|Ő|Ơ|Ø|Ǿ/' => 'O',
            '/ò|ó|ô|õ|ō|ŏ|ǒ|ő|ơ|ø|ǿ|º/' => 'o',
            '/Ŕ|Ŗ|Ř/' => 'R',
            '/ŕ|ŗ|ř/' => 'r',
            '/Ś|Ŝ|Ş|Ș|Š/' => 'S',
            '/ś|ŝ|ş|ș|š|ſ/' => 's',
            '/Ţ|Ț|Ť|Ŧ/' => 'T',
            '/ţ|ț|ť|ŧ/' => 't',
            '/Ù|Ú|Û|Ũ|Ū|Ŭ|Ů|Ű|Ų|Ư|Ǔ|Ǖ|Ǘ|Ǚ|Ǜ/' => 'U',
            '/ù|ú|û|ũ|ū|ŭ|ů|ű|ų|ư|ǔ|ǖ|ǘ|ǚ|ǜ/' => 'u',
            '/Ý|Ÿ|Ŷ/' => 'Y',
            '/ý|ÿ|ŷ/' => 'y',
            '/Ŵ/' => 'W',
            '/ŵ/' => 'w',
            '/Ź|Ż|Ž/' => 'Z',
            '/ź|ż|ž/' => 'z',
            '/Æ|Ǽ/' => 'AE',
            '/ß/' => 'ss',
            '/Ĳ/' => 'IJ',
            '/ĳ/' => 'ij',
            '/Œ/' => 'OE',
            '/ƒ/' => 'f'
        );

        $quotedReplacement = preg_quote($separator, '/');
        $merge = array(
            '/[^\s\p{Zs}\p{Ll}\p{Lm}\p{Lo}\p{Lt}\p{Lu}\p{Nd}]/mu' => ' ',
            '/[\s\p{Zs}]+/mu' => $separator,
            sprintf('/^[%s]+|[%s]+$/', $quotedReplacement, $quotedReplacement) => '',
        );
        $map = $_transliteration + $merge;
        unset($_transliteration);
        return preg_replace(array_keys($map), array_values($map), $string);

    }
}


//convert en  numbers to fa
if (!function_exists('topersian')) {
    function topersian($text)
    {
        $arabic = array('ي', 'ك', '٤', '٥', '٦');
        $persian = array('ی', 'ک', '۴', '۵', '۶');
        $text = str_replace($arabic, $persian, $text);
        return $text;
    }
}
//str_replace that work with farsi
if (!function_exists('mb_str_replace')) {
    function mb_str_replace($search, $replace, $subject, &$count = 0)
    {
        if (!is_array($subject)) {
            // Normalize $search and $replace so they are both arrays of the same length
            $searches = is_array($search) ? array_values($search) : array($search);
            $replacements = is_array($replace) ? array_values($replace) : array($replace);
            $replacements = array_pad($replacements, count($searches), '');
            foreach ($searches as $key => $search) {
                $parts = mb_split(preg_quote($search), $subject);
                $count += count($parts) - 1;
                $subject = implode($replacements[$key], $parts);
            }
        } else {
            // Call mb_str_replace for each subject in array, recursively
            foreach ($subject as $key => $value) {
                $subject[$key] = mb_str_replace($search, $replace, $value, $count);
            }
        }
        return $subject;
    }


}
