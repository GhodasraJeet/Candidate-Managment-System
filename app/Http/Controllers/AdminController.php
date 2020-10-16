<?php

namespace App\Http\Controllers;

use App\User;
use App\Category;
use App\Interview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{

    public function home()
    {
        $category=Category::count();
        $interview=Interview::count();
        $hr=User::where('role','hr')->count();
        $recent_candidate=Interview::orderBy('id','desc')->take(5)->get();
        return view('admin.home',compact('category','interview','hr','recent_candidate'));
    }

}
