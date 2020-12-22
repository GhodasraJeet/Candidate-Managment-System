<?php

namespace App\Http\Controllers;

use App\User;
use App\Interview;
use App\Jobs\NewUser;
use App\Jobs\Adminjob;
use App\Mail\AdminMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AdminMailController extends Controller
{
    public function viewmail()
    {
        $candidates=Interview::get();
        $hrs=User::where('role','hr')->get();
        return view('admin.mail.index',compact('candidates','hrs'));
    }
    public function sendmail(Request $request)
    {
        $this->validate(
            $request,
            [
                "role"=>"required",
                "subject" => "required",
                "description" => "required",
            ]
        );
        if(Auth::user()->role=="admin")
        {
            if($request->role=="hr")
            {
                $user=User::where('role','hr')->get();
            }
            else if($request->role=="candidates")
            {
                $user=Interview::get();
            }
            else if($request->role=="singlehr"){
                $user=User::whereIn('id',$request->singlehr)->get();
            }
            else if($request->role=="singlecandidates"){
                $user=Interview::whereIn('id',$request->singlecandidates)->get();
            }
            Adminjob::dispatch($user,$request->subject,$request->description)->delay(now()->addMinutes(1));
            return redirect()->route('admin.home')->with('success','Email sent successfully');
        }
        else if(Auth::user()->role=="hr")
        {
            if($request->role=="candidates"){
                $user=Interview::get();
            }
            else if($request->role=="singlecandidates"){
                $user=Interview::whereIn('id',$request->singlecandidates)->get();
            }
            Adminjob::dispatch($user,$request->subject,$request->description)->delay(now()->addMinutes(1));
            return redirect()->route('hr.home')->with('success','Email sent successfully');
        }
    }

    public function hrviewmail()
    {
        $candidates=Interview::get();
        return view('hr.mail.index',compact('candidates'));
    }
}
