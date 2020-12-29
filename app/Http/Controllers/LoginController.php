<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
        $attr = [
            'email' => $request->email,
            'password' => $request->password
        ];
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => 'http://localhost/candidate/public/api/login',
            CURLOPT_USERAGENT => 'login',
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => $attr
        ]);
        $resp = curl_exec($curl);
        $details=json_decode($resp,true);
        curl_close($curl);
        if($details['success']==true){
            $request->session()->put('email',$details);
            $a=$request->session()->get('email');
            if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){

           if($a['user']['role']=="admin"){
               return redirect()->route('admin.home');
           }
           else{
            auth()->user()->update(['device_token'=>$request->token]);
            return redirect()->route('hr.home');
           }
        }
         }
         else
         {
            return redirect()->route('login')->with('warning','Please Enter Valid Email and Password');
         }

    }

    public function logout(Request $request)
    {
        $user=$request->session()->get('email');
        // $token = "Authorization: Bearer ".$user['token']['token'];
        // dd($user['token']['token']);
        // $category = Curl::to('http://localhost/candidate/public/api/logout')
        // ->withBearer($user['token']['token'])
        // ->withData()
        // ->post();
        // dd($category);
        Session::flush();
        Auth::logout();
        return redirect('/');
    }
}
