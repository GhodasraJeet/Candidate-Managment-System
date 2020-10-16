<?php

namespace App\Http\Controllers;

use Exception;
use App\Category;
use App\Interview;
use Illuminate\Http\Request;

class InterviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax())
        {
            if($request->category)
            {
                if(!empty($request->from_date))
                {
                    $category=$request->category;
                    $interviewDetails=Interview::with('getCategory','getHrDetails')->whereHas('getCategory',function($q) use($category){
                        $q->where('id','=',$category);
                    })->whereBetween('created_at', array($request->from_date, $request->to_date))->where('hr_id','!=',auth()->user()->id)->get();
                }
                else
                {
                    $category=$request->category;
                    $interviewDetails=Interview::with('getCategory','getHrDetails')->whereHas('getCategory',function($q) use($category){
                        $q->where('id','=',$category);
                    })->where('hr_id','!=',auth()->user()->id)->get();
                }
            }
            else
            {
                if(!empty($request->from_date))
                {
                    $interviewDetails=Interview::with('getCategory','getHrDetails')->whereBetween('created_at', array($request->from_date, $request->to_date))->where('hr_id','!=',auth()->user()->id)->get();
                }
                else
                {
                    $interviewDetails=Interview::with('getCategory','getHrDetails')->where('hr_id','!=',auth()->user()->id)->get();
                }
            }

            return datatables()->of($interviewDetails)->addIndexColumn()
            ->editColumn('category',function($interviewDetails){
                return $interviewDetails->getCategory->name;
            })
            ->addColumn('action', function($row){

                    $btn =  $row->getHrDetails->name.' cannot edit or delete.';

                return $btn;
            })->rawColumns(['action','category'])->make(true);
        }
        $category = Category::get();
        return view('hr.interview.interview_details',compact('category'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categoryDetails=Category::get();
        return view('hr.interview.create',compact('categoryDetails'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                "candidate_name" => "required|string|unique:interview,name",
                "candidate_email"=> "required|string|unique:interview,email",
                "candidate_graduate"=> "required|string",
                "candidate_phone"=> "required|digits:10",
                "candidate_otherphone"=> "required|digits:10",
                "candidate_category"=>"required",
                "candidate_expereince"=>"required|numeric",
                "candidate_current_salary"=>"required|numeric",
                "candidate_expected_salary"=>"required|numeric",
                "candidate_practical_remarks"=>"required|numeric",
                "candidate_technical_remarks"=>"required|numeric",
                "candidate_general_remarks"=>"required|numeric"
            ]
        );
        $category=new Interview;
        $category->name=$request->candidate_name;
        $category->email=$request->candidate_email;
        $category->graduation=$request->candidate_graduate;
        $category->phone=$request->candidate_phone;
        $category->other_phone=$request->candidate_otherphone;
        $category->category_id=$request->candidate_category;
        $category->experience=$request->candidate_expereince;
        $category->current_salary=$request->candidate_current_salary;
        $category->expected_salary=$request->candidate_expected_salary;
        $category->practical_remarks=$request->candidate_practical_remarks;
        $category->technical_remarks=$request->candidate_technical_remarks;
        $category->general_remarks=$request->candidate_general_remarks;
        $category->hr_id=auth()->user()->id;
        if($category->save())
        {
            return redirect()->route('hrinterview.mycandidate')->with('success','Interview added Successfully...!');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try
        {
            $interviewDetails=Interview::with('getCategory')->findorfail($id);
        }
        catch(Exception $exception)
        {
            throw new \App\Exceptions\UserNotFoundException('Interviewer not found');
        }
        return view('hr.interview.show',compact('interviewDetails'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try
        {
            $interviewdetails=Interview::findorfail($id);
            $categoryDetails=Category::get();
            return view('hr.interview.edit',compact('interviewdetails','categoryDetails'));
        }
        catch(Exception $exception)
        {
            throw new \App\Exceptions\UserNotFoundException('Interviewer not found');

        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try
        {
            $result=Interview::find($id)
            ->update(
                [
                    'name'=>$request->candidate_name,
        'email'=>$request->candidate_email,
        'graduation'=>$request->candidate_graduate,
        'phone'=>$request->candidate_phone,
        'other_phone'=>$request->candidate_otherphone,
        'category_id'=>$request->candidate_category,
        'experience'=>$request->candidate_expereince,
        'current_salary'=>$request->candidate_current_salary,
        'expected_salary'=>$request->candidate_expected_salary,
        'practical_remarks'=>$request->candidate_practical_remarks,
        'technical_remarks'=>$request->candidate_technical_remarks,
        'general_remarks'=>$request->candidate_general_remarks
                ]
            );
            if($result)
            {
                return redirect()->route('hrinterview.mycandidate')->with('success','Interview Updated successfully...!');
            }
        }
        catch(Exception $exception)
        {
            dd('ee');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try
        {
            Interview::findorfail($id)->delete();
            $msg['msg']="Not Delete Beacuse candidate is exist";
            $msg['status']="false";
            return json_encode($msg);
            // return redirect()->route('hrinterview.mycandidate')->with('warning','Interview deleted Successfully...!');
        }
        catch(Exception $ex)
        {
            $msg['msg']="Not Delete Beacuse candidate is exist";
            $msg['status']="false";
            return json_encode($msg);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function mycandidate(Request $request)
    {
        if($request->ajax())
        {
            if($request->category)
            {
                if(!empty($request->from_date))
                {
                    $category=$request->category;
                    $interviewDetails=Interview::with('getCategory')->whereHas('getCategory',function($q) use($category){
                        $q->where('id','=',$category);
                    })->whereBetween('created_at', array($request->from_date, $request->to_date))->where('hr_id',auth()->user()->id)->get();
                }
                else
                {
                    $category=$request->category;
                    $interviewDetails=Interview::with('getCategory')->whereHas('getCategory',function($q) use($category){
                        $q->where('id','=',$category);
                    })->where('hr_id',auth()->user()->id)->get();
                }
            }
            else
            {
                if(!empty($request->from_date))
                {
                    $interviewDetails=Interview::with('getCategory')->whereBetween('created_at', array($request->from_date, $request->to_date))->where('hr_id',auth()->user()->id)->get();
                }
                else
                {
                    $interviewDetails=Interview::with('getCategory')->where('hr_id',auth()->user()->id)->get();
                }
            }

            return datatables()->of($interviewDetails)->addIndexColumn()
            ->editColumn('category',function($interviewDetails){
                return $interviewDetails->getCategory->name;
            })
            ->addColumn('action', function($row){

                    $btn = '<div class="d-flex justify-content-around align-items-center"><a href="'.route('hrinterview.show',$row->id).'" class="edit mr-3"><i class="fa fa-eye"></i></a>';
                    $btn = $btn.'<button class="btn deleteCandidate" data-id="'.$row->id.'"><i class="fa fa-trash"></i></button>';
                    $btn = $btn.'<a href="'.route('hrinterview.edit',$row->id).'" class="edit mr-3"><i class="fa fa-edit"></i></a></div>';

                return $btn;
            })->rawColumns(['action','category'])->make(true);
        }
        $category = Category::get();
        return view('hr.interview.mycandidate',compact('category'));
    }
}
