<?php

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

function getLocation()
{
    $country = null;
    $value = Session::get('country');
    if($value){
        $country = $value;
    }

    return $country;

    // return 'some';
}

function ticketNumber()
{
    $userId = Auth::user()->id;
    $ticket = 'T-' . $userId . '000';

    $count = Ticket::where('ticket_number', 'LIKE', $ticket . '%')->count();
    $suffix = $count ? $count + 1 : $count + 1;
    $ticket .= $suffix;
    return $ticket;
}


?>
