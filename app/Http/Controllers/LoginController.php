<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
         // Set some options - we are passing in a useragent too here
         curl_setopt_array($curl, [
             CURLOPT_RETURNTRANSFER => 1,
             CURLOPT_URL => 'http://localhost/candidate/public/api/login',
             CURLOPT_USERAGENT => 'login',
             CURLOPT_POST => 1,
             CURLOPT_POSTFIELDS => $attr
         ]);
         $resp = curl_exec($curl);
         $details=json_decode($resp);
         curl_close($curl);
        //  dd($details);
         $request->session()->put('email',$details);
         $a=$request->session()->get('email');
         Auth::attempt(['email' => $request->email, 'password' => $request->password]);
        //  dd($a);
        // $data = $request->session()->all();
        // dd($data);

        // if(Auth::attempt(['email'=> $request->email,'password'=>$request->password])){
            if($a->user->role=="admin"){
                return redirect()->route('admin.home');
            }
            else{
                return redirect()->route('hr.home');
            }
        // }
        // else{
        //     return back()->with('warning','Please Enter Valid Credantials');
        // }
    }
    protected function validateLogin(Request $request) {
        $this->validate($request, [
             $this->username() => ['required', 'string',
                        Rule::exists('users')
                        ->where(function ($query) {
                                    $query->where('role', 'admin');
                                }),
            ],
            'password' => 'required|string',
        ]);
    }
    public function logout()
    {
        Session::flush();
        Auth::logout();
        return redirect('/');
    }
}
