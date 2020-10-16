<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FaltuController extends Controller
{
    public function index(Request $request)
    {
        if(request()->ajax())
        {
         if(!empty($request->from_date))
         {
          $data = DB::table('category')
            ->whereBetween('created_at', array($request->from_date, $request->to_date))
            ->get();
         }
         else
         {
          $data = DB::table('category')
            ->get();
         }
         return datatables()->of($data)->make(true);
        }
        return view('faltu');
       }

       public function fetch()
       {
        $hrfulldetails=User::with('getCandidate')->withTrashed()->where('role','hr')->get();
dd($hrfulldetails);
       }
}
