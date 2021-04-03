<?php

namespace App\Http\Core\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Core\Models\Message;
use App\Http\Core\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    public function index()
    {

//        if (!Auth::user()->can('read-tickets')) {
//            return back()->with('error-message', 'دسترسی شما به این بخش محدود می باشد!');
//        }

        $tickets = Ticket::latest()->get();
//       dd( $tickets[0]->latestMessage[0]->body);
        return view('panel.tickets.index', compact('tickets'));

    }

    //
    public function show(Ticket $ticket)
    {
//        if (!Auth::user()->can('read-tickets')) {
//            return back()->with('error-message', 'دسترسی شما به این بخش محدود می باشد!');
//        }
        $messages = Message::where('ticket_id', $ticket->id)->oldest()->get();
//dd($messages);
        return view('panel.tickets.show', compact('ticket', 'messages'));
    }

    public function update(Ticket $ticket, Request $request)
    {
//        if (!Auth::user()->can('update-tickets')) {
//            return back()->with('error-message', 'دسترسی شما به این بخش محدود می باشد!');
//        }

        $ticket->update($request->all());
        return view('panel.tickets.index', compact('tickets'))
            ->with(['alert_title' => 'موفق', 'alert_body' => 'تیکت با موفقیت به روزرسانی شد']);

    }

    public function storeMessage(Request $request)
    {
//        dd($request->all());
        $request->validate([
            'ticket_id' => ['required'],
            'body' => ['required'],

        ]);
        $thicket =Ticket::findOrFail($request->ticket_id);
        $thicket->status = 1;

        $thicket->save();

//        dd($request->all(), $thicket);
        $message = $thicket->messages()->create($request->all());
        $message->user_id = Auth::user()->id;
        $message->save();
        return back() ->with(['alert_title' => 'موفق', 'alert_body' => 'پیام با موفقیت ثبت شد']);

    }

    public function store(Request $request)
    {
//        if (!Auth::user()->can('create-tickets')) {
//            return back()->with('error-message', 'دسترسی شما به این بخش محدود می باشد!');
//        }
        $request->validate([
            'ticket_id' => ['required'],
            'body' => ['required'],

        ]);

        $thicket = Ticket::findOrFail($request->ticket_id);
        $message = $thicket->messages()->create($request->all());
        $thicket->status = 1;
        $message->user_id = Auth::id();
        $thicket->save();
        $message->save();
        return back()            ->with(['alert_title' => 'موفق', 'alert_body' => 'تیکت با موفقیت ثبت شد']);;
    }

    public function destroy(Ticket $ticket)
    {
//todo cjeck if usless
        //todo add message
//        if (!Auth::user()->can('delete-tickets')) {
//            return back()->with('error-message', 'دسترسی شما به این بخش محدود می باشد!');
//        }

        $ticket->messages()->delete();
        $ticket->delete();
        return redirect()->back()
            ->with(['alert_title' => 'موفق', 'alert_body' => 'تیکت با موفقیت حذف شد']);

    }

    public function updateStatus()
    {
//        if (!Auth::user()->can('update-tickets')) {
//            return back()->with('error-message', 'دسترسی شما به این بخش محدود می باشد!');
//        }
        $ticket = Ticket::findOrFail(\request()->id);

        $ticket->update([
            'status' => \request()->status
        ]);

        return back()
            ->with(['alert_title' => 'موفق', 'alert_body' => 'تیکت با موفقیت به روزرسانی شد']);

    }
}
