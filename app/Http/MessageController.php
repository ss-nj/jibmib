<?php

namespace App\Http;

 use App\Http\Controllers\Controller;
 use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    //
    public function store(Request $request)
    {
        //todo itts usless?
//        dd($request->all());
        $thicket = Auth::user()->tickets()->findOrFail($request->ticket_id);
//        dd($request->all(),$thicket);
        $message = $thicket->messages()->create($request->all());
        $message->user_id = Auth::user()->id;
        $message->save();
        return back()
            ->with(['alert_title' => 'موفق', 'alert_body' => 'پیام با موفقیت ثبت شد']);

    }
}
