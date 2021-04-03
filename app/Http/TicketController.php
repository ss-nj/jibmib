<?php

namespace App\Http;


use App\Http\Controllers\Controller;
use App\Http\Core\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $tickets = Ticket::Latest()->where('user_id', auth()->user()->id)->paginate(10);
        return view( 'user.tickets.index', compact('tickets'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
      */
    public function store(Request $request)
    {
//        if (!Auth::user()->can('create-ticket')) {
//            return back()->with('error-message', 'دسترسی شما به این بخش محدود می باشد!');
//        }
        $request->validate([
            'title' => ['required'],
            'body' => ['required'],

        ]);
        $thicket = Auth::user()->tickets()->create($request->all());
        $message=  $thicket->messages()->create($request->all());
        $message->user_id = Auth::id();

        return back()
            ->with(['alert_title' => 'موفق', 'alert_body' => 'تیکت با موفقیت ثبت شد']);

    }

    /**
     * Display the specified resource.
     *
     * @param ticket $ticket
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(ticket $ticket)
    {
        return view( 'user.tickets.show', compact('ticket'));
    }


    public function change_user_seen(Request $request)
    {
//        dd($request->all());
        $result = Ticket::where([['id', $request->id], ['answer_time', '!=', null]])
            ->update(['user_seen' => '1']);

        if ($result)
            return response()->json(['message' => true], 200);
        else
            return response()->json(['message' => false]);
    }
}
