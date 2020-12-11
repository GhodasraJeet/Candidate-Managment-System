<?php

namespace App\Http\Controllers;

use App\Category;
use App\Interview;
use App\Plan;
use Illuminate\Support\Facades\Auth;

class HrController extends Controller
{
    // Display Home Page and Total Category and Candidates

    public function home()
    {
        $currentPlan='';
        if(Auth::user()->subscribed('default'))
        {
            $user=Auth::user();
            $plan_id=$user->subscription('default')->stripe_plan;
            $currentPlan=Plan::where('stripe_plan',$plan_id)->get();
        }

        $category=Category::count();
        $interview=Interview::count();
        return view('hr.home',compact('category','interview','currentPlan'));
    }
}
