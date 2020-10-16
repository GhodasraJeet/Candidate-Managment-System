<?php

namespace App\Http\Controllers;

use App\Category;
use App\Interview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class HrController extends Controller
{
    public function home()
    {
        $category=Category::count();
        $interview=Interview::count();
        return view('hr.home',compact('category','interview'));
    }

}
