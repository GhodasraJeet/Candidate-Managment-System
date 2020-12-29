<?php

namespace App\Http\Controllers;

use App\Item;
use App\State;
use App\Student;
use App\Technology;
use Illuminate\Http\Request;

class DragController extends Controller
{

    public function store(Request $request)
    {
        if ($request->hasFile('attachment')) {
            $image = $request->file('attachment');
            $name = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/attachment');
            $image->move($destinationPath, $name);
        }
        $student=new Student();
        $student->name=$request->name;
        $student->email=$request->email;
        $student->phone=$request->phone;
        $student->attachment=$name;
        $student->state_id=$request->state;
        $student->save();
        $student->getTechnology()->attach($request->technology);
        return back();
    }

    public function index(Request $request){
        // $data = Item::orderBy('sort_id','asc')->get();
        // return view('admin.dragAndDroppable',compact('data'));
        $applicants=Student::where('state_id',1)->get();
        $hrrounds=Student::where('state_id',2)->get();
        $technicals=Student::where('state_id',3)->get();
        $practicals=Student::where('state_id',4)->get();
        $offerces=Student::where('state_id',5)->get();
        $rejectes=Student::where('state_id',6)->get();
        $holds=Student::where('state_id',7)->get();

        $technology=Technology::all();
        $state=State::all();
        return view('drag',compact('technology','state','applicants','hrrounds','technicals','practicals','offerces','rejectes','holds'));

    }

    public function updateOrder(Request $request){
        // if($request->has('ids')){
        //     $arr = explode(',',$request->input('ids'));

        //     foreach($arr as $sortOrder => $id){
        //         $menu = Item::find($id);
        //         $menu->sort_id = $sortOrder;
        //         $menu->save();
        //     }
        //     return ['success'=>true,'message'=>'Updated'];
        // }
        // if()
        $state_id=$request->state;
        $student=Student::find($request->ids);
        $student->state_id=$state_id;
        $student->save();
        return ['success'=>true,'message'=>'Updated'];
    }
}
