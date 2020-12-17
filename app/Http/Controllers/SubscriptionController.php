<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Plan;
use Stripe\Stripe;
use App\User;
use Laravel\Cashier\Cashier;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    protected $stripe;

    public function __construct()
    {
        $this->stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
    }
    public function index()
    {
        $plans = Plan::all();
        return view('hr.plans', compact('plans'));
    }

    public function create(Request $request, Plan $plan)
    {
        $plan = Plan::findOrFail($request->get('plan'));

        $user = $request->user();
        $paymentMethod = $request->paymentMethod;

        $user->createOrGetStripeCustomer();
        $user->updateDefaultPaymentMethod($paymentMethod);
        $user->newSubscription('default', $plan->stripe_plan)
        // ->trialDays(30)
            ->create($paymentMethod, [
                'email' => $user->email,
            ]);

        return redirect()->route('hr.home')->with('success', 'Your plan subscribed successfully');
    }
    public function show(Plan $plan, Request $request)
    {
        // $user=$request->session()->get('email');
        // dd($user->user);
        // $paymentMethods = $request->user()->paymentMethods();
        $intent = $request->user()->createSetupIntent();
        return view('hr.singleplan', compact('plan','intent'));
    }
    public function cancel()
    {
        Auth::user()->subscription('default')->cancelNow();
        return redirect()->route('plans.index');
    }
}
