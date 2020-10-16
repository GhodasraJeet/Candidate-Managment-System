<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }
    public function submitLogin(Request $request)
    {
        $this->validate($request,
        [
            "email"=>"required",
            "password"=>"required|max:20|min:7",
        ]);
        if(Auth::attempt(['email'=> $request->email,'password'=>$request->password]))
        {
            if(auth()->user()->role=="admin")
            {
                return redirect('home');
            }
            else
            {
                return redirect('hrhome');
            }
        }
        else
        {
            return back()->with('warning','Please Enter Valid Credantials');
        }
    }
    public function logout()
    {
        Session::flush();
        Auth::logout();
        return redirect('login');
    }
}
