<?php

namespace App\Http\Controllers;

use App\User;
use App\Category;
use App\Interview;
use App\Plan;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    // Display Admin Homepage Category,Candidates and HR Count
    public function home(Request $request)
    {

        // $invoices = auth()->user()->invoicesIncludingPending();
        // dd($invoices);
        // dd($request->user()->asStripeCustomer()->subscriptions);
        $category=Category::count();
        $interview=Interview::count();
        $plans=Plan::count();
        $hr=User::where('role','hr')->count();
        $recent_candidate=Interview::orderBy('id','desc')->take(5)->get();
        return view('admin.home',compact('category','interview','hr','recent_candidate','plans'));
    }

}
