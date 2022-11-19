<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ReferralBonus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReferralController extends Controller
{
    public function index()
    {
        $users = User::with('referral')->where('referred_by', Auth::user()->affiliate_id)->latest()->get();
        // return $users;
        // $user = User::get()->last();
        // $referredUser  = User::where('affiliate_id', $user->referred_by)->first();
            // ReferralBonus::create([
            //     'user_id'      => $user->id,
            //     'referred_by'  => $referredUser->id,
            //     'affiliate_id' => $user->referred_by,
            //     'price'        => 7
            // ]);

            // return $referredUser;
        return view('backend.admin.referral.index', compact('users'));
    }

    public function refereellink()
    {
        return redirect()->route('register');
    }
}
