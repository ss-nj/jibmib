<?php

namespace App\Http;


use App\Http\Controllers\Controller;
use App\Http\Core\Models\Ticket;
use App\Support\JsonResponse;
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
        return view( 'front.tickets.index', compact('tickets'));
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
            'title' => ['required','max:80'],
            'body' => ['required','max:500'],
        ]);

        $thicket = Auth::user()->tickets()->create($request->all());
        $message=  $thicket->messages()->create($request->all());
        $message->user_id = Auth::id();
        $message->save();

        return JsonResponse::sendJsonResponse(1, 'موفق', 'با موفقیت ثبت شد', 'DATATABLE_REFRESH');
    }

    /**
     * Display the specified resource.
     *
     * @param ticket $ticket
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(ticket $ticket)
    {
        return view( 'front.tickets.show', compact('ticket'));
    }

    public function storeMessage(Request $request,Ticket $ticket)
    {

        //check if user own it
        $thicket = Auth::user()->tickets()->findOrFail($ticket->id);

        $request->validate([
            'body' => ['required','max:500'],
        ]);

        $message = $thicket->messages()->create($request->all());
        $message->user_id = Auth::id();
        $thicket->status = 0;
        $message->save();
        $thicket->save();

        return JsonResponse::sendJsonResponse(1, 'موفق', 'با موفقیت ثبت شد', 'SHOW_AND_REFRESH');

    }


}
