<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function show_register()
    {
        return view('User.Register');
    }
    public function user_register(Request $request)
    {
        $checkUser = User::orderby('id','DESC')->first();
        $data = $request->all();
        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = bcrypt($data['name']);
        if(($checkUser->email) == $data['email']){
            return redirect()->back()->with('message','This email had been used before! Please use another email');
    }
        if($checkUser->name == $data['name']){
            return redirect()->back()->with('message','This name had been used before! Please use another name');
        }
        $user->save();
        return redirect()->back()->with('message','Register Successfully!Please go to login page');
    }
    public function show_login()
    {
        return view('User.Login');
    }
    public function user_login(Request $request)
    {
        $email = $request->email;
        $password= bcrypt($request->password);
        $checkAccount =  User::orderby('id','DESC')->first();
        if($checkAccount->email != $email && $checkAccount->password != $password){
            return Redirect::to('/show-login')->with('message','email or password is not correct');
        }
        Session::put('id',$checkAccount->id);
        return Redirect::to('/');
    }
}
