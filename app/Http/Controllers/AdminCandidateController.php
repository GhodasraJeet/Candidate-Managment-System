<?php

namespace App\Http\Controllers;

use App\User;
use Exception;
use App\Category;
use App\Interview;
use Illuminate\Http\Request;
use App\DataTables\InterviewerDataTable;
use App\Exceptions\UserNotFoundException;

class AdminCandidateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(InterviewerDataTable $datatable)
    {
        $category=Category::get();
        $hr=User::where('role','hr')->get();
        return $datatable->render('admin.candidate.index',['category'=>$category,'hr'=>$hr]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Intreview  $intreview
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            $hrfulldetails=Interview::findOrFail($id);
        }
        catch(Exception $exception){
            throw new \App\Exceptions\UserNotFoundException('Candidate not found');
        }
        return view('admin.candidate.show',compact('hrfulldetails'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Intreview  $intreview
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try{
            $hrfulldetails = Interview::findOrFail($id);
            $category=Category::get();
        }
        catch (Exception $exception) {
            throw new \App\Exceptions\UserNotFoundException('Candidate not found');
        }
        return view('admin.candidate.edit',compact('hrfulldetails','category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Intreview  $intreview
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
                return redirect()->route('candidates.index')->with('success','Interview Updated successfully...!');
            }
        }
        catch(Exception $exception)
        {
            throw new UserNotFoundException('Candidate not found');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Intreview  $intreview
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try
        {
            $result=Interview::where('id',$id)->delete();
            if($result)
            {
                $msg['msg']="Candidate delete successfully..!";
                $msg['status']="false";
                return json_encode($msg);
            }
            else{
                $msg['msg']="Candidate not Deleted";
                $msg['status']="true";
                return json_encode($msg);
            }
        }
        catch(Exception $ex)
        {
            throw new UserNotFoundException('Candidate counld not be deleted');
        }
    }
}
