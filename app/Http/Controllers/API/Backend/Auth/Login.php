<?php

namespace App\Http\Controllers\API\Backend\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Hash;
use Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;



class Login extends Controller
{
    function login(Request $request){
    
        $email=$request->input('email');
        $psw=$request->input('password');

        $validator = Validator::make($request->all(),[
                   
            'email' => 'required|max:255',
            'password' => 'required|min:5|max:255',                  
        ]);
       
        if ($validator->fails()) {
            return $validator->errors();
        }

        if (Auth::attempt(['email' => $email, 'password' => $psw])) {
            if(Auth::check()){
                return response()->json(Auth::user());               
            }else{
                return "user data fetch not success";
            }
        }else {
            return 'login fail';
        }
       
    }
    public function logout()
    {      
         Auth::logout();
         Session::flush();
         return response()->json(["logout"=> TRUE ,"massege"=>"logout success"]);
    }
}
