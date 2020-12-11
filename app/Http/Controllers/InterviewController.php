<?php

namespace App\Http\Controllers;

use Exception;
use App\Category;
use App\Interview;
use Illuminate\Http\Request;
use App\DataTables\InterviewerDataTable;
use App\Exceptions\UserNotFoundException;

class InterviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(InterviewerDataTable $datatable)
    {
        return $datatable->render('hr.interview.interview_details');

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
                "candidate_name" => "required|string",
                "candidate_email"=> "required|string|unique:interview,email",
                "candidate_graduate"=> "required|string",
                "candidate_phone"=> "required|min:10",
                "candidate_otherphone"=> "required|min:10",
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
            return redirect()->route('interview.index')->with('success','Interview added Successfully...!');
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
            throw new UserNotFoundException('Interviewer not found');
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
            $hr_id=Interview::where('id',$id)->value('hr_id');
            if(auth()->user()->id==$hr_id)
            {
                $interviewdetails=Interview::findorfail($id);
                $categoryDetails=Category::get();
                return view('hr.interview.edit',compact('interviewdetails','categoryDetails'));
            }
            else
            {
                return redirect()->route('interview.index')->with('warning','You are not alligble to edit candidate...!');
            }

        }
        catch(Exception $exception)
        {
            throw new UserNotFoundException('Interviewer not found');
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
                return redirect()->route('interview.index')->with('success','Interview Updated successfully...!');
            }
        }
        catch(Exception $exception){
            throw new UserNotFoundException('Interviewer not found');
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
            $hr_id=Interview::where('id',$id)->value('hr_id');
            if(auth()->user()->id==$hr_id)
            {
                Interview::findorfail($id)->delete();
                $msg['msg']="Candidate Deleted";
                $msg['status']="true";
                return json_encode($msg);
            }
            else
            {
                return redirect()->route('interview.index')->with('warning','You are not alligble to edit candidate...!');
            }
        }
        catch(Exception $ex){
            $msg['msg']="Not Delete Beacuse candidate is exist";
            $msg['status']="false";
            return json_encode($msg);
        }
    }

}
