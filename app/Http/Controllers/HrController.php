<?php

namespace App\Http\Controllers;

use App\Plan;
use App\Category;
use App\Interview;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class HrController extends Controller
{
    // Display Home Page and Total Category and Candidates

    public function home(Request $request)
    {
        // $a=$request->user()->asStripeCustomer()->subscriptions;
        // $a->data[0]->plan->id;
        // $a=Plan::where('stripe_plan',$a->data[0]->plan->id)->get();
        // $sub = $user->subscription('main')->asStripeSubscription();
        // $plan = $sub->plan;
        // dd($a);
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
