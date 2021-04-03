<?php

namespace App\Http\Core\Controllers;

use App\Http\Controllers\Controller;

class LocalizationController extends Controller
{
    //
    public function change_lang($lang){

        if(in_array($lang,['en','fa'])){
            session(['locale'=> $lang]);

        }
        return back();
    }
}
