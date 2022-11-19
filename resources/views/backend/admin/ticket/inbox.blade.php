@extends('backend.layout.app')

@push('custom-css')
@endpush

@section('main_section')
<div id="content-page" class="content-page">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="iq-card">
                    <div class="iq-card-header d-flex justify-content-between">
                        <div class="iq-header-title">
                            <h4 class="card-title">Ticket</h4>
                            <p>#{{$ticket->ticket_number}}</p>
                        </div>
                        @if ($ticket->status == 'open')
                        <div class="iq-header-title justify-content-between">
                            <form action="{{route('ticket.update', $ticket->id)}}" method="POST" >
                                @csrf
                                @method('put')
                                <span> Status:</span>
                                <select name="status" id="" class="form-control" onchange="this.form.submit()">
                                    <option value="pending" disabled>Pending</option>
                                    <option value="open" @if($ticket->status == 'open') selected @endif>Open</option>
                                    <option value="completed"  @if($ticket->status == 'completed') selected @endif>Completed</option>
                                </select>
                            </form>
                        </div>
                        @endif

                    </div>
                    <div class="iq-card-body">
                        @if ($ticket->status == 'open' || $ticket->status == 'completed')
                        <div class="messaging">
                            <div class="inbox_msg">
                                <div class="mesgs">
                                    <div class="msg_history">
                                        <div class="incoming_msg">
                                            <div class="incoming_msg_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div>
                                            <div class="received_msg">
                                                <div class="received_withd_msg">
                                                    <p>Ticket Message: <strong>{{$ticket->message}}</strong></p>
                                                    <span class="time_date"> {{$ticket->created_at->format('g:i A | d M Y')}} </span>
                                                </div>
                                            </div>
                                        </div>
                                        @foreach ($ticket->replies as $reply)
                                        @if($reply->is_user == true)
                                        <div class="incoming_msg">
                                            <div class="incoming_msg_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div>
                                            <div class="received_msg">
                                                <div class="received_withd_msg">
                                                    <p>{{$reply->message}}</p>
                                                    <span class="time_date"> {{$reply->created_at->format('g:i A | d M Y')}} </span>
                                                </div>
                                            </div>
                                        </div>
                                        @endif

                                        @if($reply->is_admin == true)
                                        <div class="outgoing_msg">
                                            <div class="sent_msg">
                                                <p>{{$reply->message}}</p>
                                                <span class="time_date"> {{$reply->created_at->format('g:i A | d M Y')}} </span>
                                            </div>
                                        </div>
                                        @endif
                                        @endforeach
                                    </div>
                                    <div class="type_msg">
                                        @if ($ticket->status == 'open')
                                        <form action="{{route('adminticket.reply.store', $ticket->id)}}" method="post">
                                            @csrf
                                            <div class="input_msg_write">
                                                <input type="text" class="write_msg" name="message" placeholder="Type a message" />
                                                <button class="msg_send_btn" type="submit"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
                                            </div>
                                        </form>
                                        @elseif($ticket->status == 'completed')
                                            <p>Ticket has been closed.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        @elseif($ticket->status == 'pending')
                        <form action="{{route('ticket.update', $ticket->id)}}" method="POST">
                            @csrf
                            @method('put')
                            <table class="table table-bordered">
                                {{-- <thead>
                                    <tr>
                                        <th scope="col">Name</th>
                                        <th scope="col">Description</th>
                                    </tr>
                                </thead> --}}
                                <tbody>
                                    <tr>
                                        <td colspan="2">
                                            <strong>Title:</strong> <br>
                                            <p>{{$ticket->title}}</p>
                                            <strong>Message: </strong> <br>
                                            <p>{{$ticket->message}}</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>User</td>
                                        <td>: {{$ticket->user->name}} <a href="{{route('users.show', $ticket->user_id)}}" target="_blank" class="badge badge-primary btn-sm">Click Details</a></td>
                                    </tr>
                                    <tr>
                                        <td>Status</td>
                                        <td>
                                            <select name="status" id="" class="form-control">
                                                <option value="pending" disabled>Pending</option>
                                                <option value="open">Open</option>
                                                <option value="completed">Completed</option>
                                            </select>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <button type="submit" class="btn btn-success">Submit</button>
                        </form>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
    @push('custom-css')
    <style>
        .container {
            max-width: 1170px;
            margin: auto;
        }

        img {
            max-width: 100%;
        }

        .inbox_people {
            background: #f8f8f8 none repeat scroll 0 0;
            float: left;
            overflow: hidden;
            width: 40%;
            border-right: 1px solid #c4c4c4;
        }

        .inbox_msg {
            border: 1px solid #c4c4c4;
            clear: both;
            overflow: hidden;
        }

        .top_spac {
            margin: 20px 0 0;
        }


        .recent_heading {
            float: left;
            width: 40%;
        }

        .srch_bar {
            display: inline-block;
            text-align: right;
            width: 60%;
        }

        .headind_srch {
            padding: 10px 29px 10px 20px;
            overflow: hidden;
            border-bottom: 1px solid #c4c4c4;
        }

        .recent_heading h4 {
            color: #05728f;
            font-size: 21px;
            margin: auto;
        }

        .srch_bar input {
            border: 1px solid #cdcdcd;
            border-width: 0 0 1px 0;
            width: 80%;
            padding: 2px 0 4px 6px;
            background: none;
        }

        .srch_bar .input-group-addon button {
            background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
            border: medium none;
            padding: 0;
            color: #707070;
            font-size: 18px;
        }

        .srch_bar .input-group-addon {
            margin: 0 0 0 -27px;
        }

        .chat_ib h5 {
            font-size: 15px;
            color: #464646;
            margin: 0 0 8px 0;
        }

        .chat_ib h5 span {
            font-size: 13px;
            float: right;
        }

        .chat_ib p {
            font-size: 14px;
            color: #989898;
            margin: auto
        }

        .chat_img {
            float: left;
            width: 11%;
        }

        .chat_ib {
            float: left;
            padding: 0 0 0 15px;
            width: 88%;
        }

        .chat_people {
            overflow: hidden;
            clear: both;
        }

        .chat_list {
            border-bottom: 1px solid #c4c4c4;
            margin: 0;
            padding: 18px 16px 10px;
        }

        .inbox_chat {
            height: 550px;
            overflow-y: scroll;
        }

        .active_chat {
            background: #ebebeb;
        }

        .incoming_msg_img {
            display: inline-block;
            width: 6%;
        }

        .received_msg {
            display: inline-block;
            padding: 0 0 0 10px;
            vertical-align: top;
            width: 92%;
        }

        .received_withd_msg p {
            background: #ebebeb none repeat scroll 0 0;
            border-radius: 3px;
            color: #646464;
            font-size: 14px;
            margin: 0;
            padding: 5px 10px 5px 12px;
            width: 100%;
        }

        .time_date {
            color: #747474;
            display: block;
            font-size: 12px;
            margin: 8px 0 0;
        }

        .received_withd_msg {
            width: 57%;
        }

        .mesgs {
            float: left;
            padding: 30px 15px 0 25px;
            width: 100%;
        }

        .sent_msg p {
            background: #05728f none repeat scroll 0 0;
            border-radius: 3px;
            font-size: 14px;
            margin: 0;
            color: #fff;
            padding: 5px 10px 5px 12px;
            width: 100%;
        }

        .outgoing_msg {
            overflow: hidden;
            margin: 26px 0 26px;
        }

        .sent_msg {
            float: right;
            width: 46%;
        }

        .input_msg_write input {
            background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
            border: medium none;
            color: #4c4c4c;
            font-size: 15px;
            min-height: 48px;
            width: 100%;
        }

        .type_msg {
            border-top: 1px solid #c4c4c4;
            position: relative;
        }

        .msg_send_btn {
            background: #05728f none repeat scroll 0 0;
            border: medium none;
            border-radius: 50%;
            color: #fff;
            cursor: pointer;
            font-size: 17px;
            height: 33px;
            position: absolute;
            right: 0;
            top: 11px;
            width: 33px;
        }

        .messaging {
            padding: 0 0 50px 0;
        }

        .msg_history {
            height: 516px;
            overflow-y: auto;
        }

    </style>
    @endpush
