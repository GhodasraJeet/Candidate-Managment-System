<?php

namespace App\Http\Controllers;

use App\Notification;
use App\User;
use Illuminate\Http\Request;

class FireController extends Controller
{
    protected $serverKey;
    public function __construct()
    {
        $this->serverKey = config('app.firebase_server_key');
    }
    public function index()
    {
        return view('notification');
    }
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function saveToken(Request $request)
    {
        auth()->user()->update(['device_token'=>$request->token]);
        return response()->json(['token saved successfully.']);
    }
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function sendNotification(Request $request)
    {
        $this->validate(
            $request,
            [
                "title" => "required",
                "body" => "required",
            ]
        );
        $noti=new Notification;
        // $token='cqBKnsqLRJkvHV32vhEIbz:APA91bGsq-gDLwxm-a1KW1dwqCsJKan8YiIE37aZKlgE2mxHjPWQyjBmaM-AyXaCpj-CcemUdLFW9SjAu9O7mORxjbs2RTHdTHtDVJMqeyDJ93n_cAMAganyxc3d_3kTpYLZZbOqAM5T';
        // $noti->toSingleDevice($token,$request->title,$request->body,'img/logo.png',null);
       $noti->toMultiDevice(User::where('role','hr')->get(),$request->title,$request->body,'img/logo.png',null);
        return redirect()->route('admin.home')->with('success','Notifications Successfully..!');
    }
}
