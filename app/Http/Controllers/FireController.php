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
        $noti=new Notification;
        $token='dyp4BOZxIa9J7u4epX5nSC:APA91bF7X-LdbgcAbbmHf03kjzd1OWpugQNNb6KpCKiQ6uhEgVemf8x-cWBVG1Mb9lsZs4J1DaDKZJQgyYcOKxdUxhx79MGIs0agdRpJrzCH5CVir2s1il0yyR4Z_DbXo-22J-tHwf97';
        $noti->toSingleDevice($token,$request->title,$request->body,'img/logo.png',null);
        // $noti->toMultiDevice(User::all(),'title','body builder',null,null);
// $token=
        // $this->validate(
        //     $request,
        //     [
        //         "title" => "required",
        //         "body" => "required",
        //     ]
        // );
        // $firebaseToken = User::whereNotNull('device_token')->pluck('device_token')->all();
        // $data = [
        //     "registration_ids" => $firebaseToken,
        //     "notification" => [
        //         "title" => $request->title,
        //         "body" => $request->body,
        //         "icon"=>asset('img/logo.png'),
        //     ]
        // ];
        // $dataString = json_encode($data);
        // $headers = [
        //     'Authorization: key=' . $this->serverKey,
        //     'Content-Type: application/json',
        // ];
        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        // curl_setopt($ch, CURLOPT_POST, true);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
        // $response = curl_exec($ch);
        // if($response){
            // return redirect()->route('admin.home')->with('success','Notifications Successfully..!');
        // }
    }
}
