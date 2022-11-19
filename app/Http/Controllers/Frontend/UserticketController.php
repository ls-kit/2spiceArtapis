<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\TicketReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserticketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $status = null;
        if (isset($_GET['status'])) {
            $status = trim($_GET['status']);
        };

        $tickets = Ticket::with('replies')->where('user_id', Auth::user()->id)
        ->when($status, function($query, $status){
            return $query->where('status', $status);
        })
        ->latest()
        ->paginate(10);

        return view('ticket.index', compact('tickets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('ticket.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'message' => 'required'
        ]);

        $data = [
            'ticket_number' => ticketNumber(),
            'user_id' => Auth::user()->id,
            'title' => $request->title,
            'message' => $request->message,
            'status' => 'pending'
        ];

        Ticket::create($data);

        return redirect()->route('user.ticket.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ticket = Ticket::with('replies')->where('id', $id)->first();

        $data = TicketReply::where('ticket_id', $id)->where('is_admin', 1)->update(['is_seen'=> 1]);

        return view('ticket.inbox', compact('ticket'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function replyStore(Request $request, $id)
    {
        // return 'ticket reply';
        $request->validate([
            'message'=> 'required'
        ]);

        $data = [
            'ticket_id' => $id,
            'user_id' => Auth::user()->id,
            'message' => $request->message,
            'is_seen' => false,
            'is_user' => true
        ];

        TicketReply::create($data);
        return redirect()->back();
    }
}
