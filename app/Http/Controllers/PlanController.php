<?php

namespace App\Http\Controllers;

use App\Plan;
use App\User;
use Stripe\Stripe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlanController extends Controller
{
    protected $stripe;

    public function __construct()
    {
        $this->stripe = new \Stripe\StripeClient(env("STRIPE_SECRET"));
    }
    public function index(Request $request)
    {
        // $user=Auth::user();
        // $invoices = $this->stripe->invoices->all();
        // $customer=$invoices->data;
        // dd($customer);
        $plans = Plan::all();
        $allCustomers=$this->stripe->customers->all();
        $customer=$allCustomers->data;
        // $a=User::where('stripe_id','!=','null')->with('getPlan')->get();

        return view('admin.showplan', compact('plans','customer'));
    }
    public function createPlan()
    {
        return view('admin.plan');
    }
    public function storePlan(Request $request)
    {
        $this->validate($request,
        [
            "name"=>"required|string",
            "cost"=>"required|numeric",
            "description"=>"required"
        ]);
        $data = $request->except('_token');
        $data['slug'] = strtolower($data['name']);
        $price = $data['cost'] *100;
        //create stripe product
        $stripeProduct = $this->stripe->products->create([
            'name' => $data['name'],
        ]);
        //Stripe Plan Creation
        $stripePlanCreation = $this->stripe->plans->create([
            'amount' => $price,
            'currency' => 'inr',
            'interval' => 'month', //  it can be day,week,month or year
            'product' => $stripeProduct->id,
        ]);
        $data['stripe_plan'] = $stripePlanCreation->id;
        Plan::create($data);
        return redirect()->route('plan.index')->with('success','Category added Successfully...!');
    }
    public function editplan($id)
    {
        $plan=Plan::findorfail($id);
        return view('admin.editplan',compact('plan'));
    }
    public function updateplan(Request $request,$id)
    {
        $result=Plan::find($id)
            ->update(['name' => $request->name,'cost'=>$request->cost,'description'=>$request->description]);
        return redirect()->route('plan.index')->with('success','Plan Updated successfully...!');
    }
    public function deleteplan($id)
    {
        Plan::findorfail($id)->delete();
        return redirect()->route('plan.index')->with('danger','Plan deleted Successfully...!');
    }
}
