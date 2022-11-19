<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\ContactMail;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index(){
        return view('frontend.contact');
    }

    public function sendEmail(Request $request)
    {
        $setting = Setting::first();
        $data = [
            'name'    => $request->name,
            'email'   => $request->email,
            'phone'   => $request->phone,
            'message' => $request->message
        ];

        // return $data;

        Mail::to($setting->contact_mail)->send(new ContactMail($data));
        return back()->with('message_sent', 'We have got your mail. We will contact with you very soon. Thank you.');
    }
}
