<?php

namespace App\Http\Controllers\API\Backend\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Hash;
use Validator;
use Illuminate\Support\Str;
use Auth;



class Register extends Controller
{
    function register(Request $request){

    
        $name=$request->input('name');
        $first_name=$request->input('first_name');
        $last_name=$request->input('last_name');
        $email=$request->input('email');
        $psw=$request->input('password');
       


       $validator = Validator::make($request->all(),[
            'name' => 'required|unique:users|max:255',                
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',                      
            'email' => 'required|unique:users|max:255',
            'password' => 'required|min:1|max:255',      
            
        ]);
      
 
        if ($validator->fails()) {
            return $validator->errors();
        }
       

        User::insert([
            "name"=>$name,
            "first_name"=>$first_name,
            "last_name"=>$last_name,
            "email"=>$email,
            "password"=>Hash::make($psw),
            "activated" => 0,
            "token" => Str::random(60),
            "signup_ip_address" => $request->ip(),
            "signup_confirmation_ip_address" => $request->ip(),
            "admin_ip_address" => $request->ip(),
            "auto_play" => 1,
            "affiliate_id" => Str::random(5),
        ]);
      
    }
}
