<?php

namespace App\Http\Controllers;

use Exception;
use App\Category;
use App\Interview;
use Illuminate\Http\Request;

class AdminCandidateController extends Controller
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
                        })->whereBetween('created_at', array($request->from_date, $request->to_date))
                        ->get();
                    }
                    else
                    {
                        $category=$request->category;
                        $interviewDetails=Interview::with('getCategory','getHrDetails')->whereHas('getCategory',function($q) use($category){
                            $q->where('id','=',$category);
                        })->get();
                    }
                }
                else
                {
                    if(!empty($request->from_date))
                    {
                        $interviewDetails=Interview::with('getCategory','getHrDetails')->whereBetween('created_at', array($request->from_date, $request->to_date))->get();
                    }
                    else
                    {
                        $interviewDetails=Interview::with('getCategory','getHrDetails')->get();
                    }
                }

            return datatables()->of($interviewDetails)->addIndexColumn()
            ->editColumn('category',function($interviewDetails){
                return $interviewDetails->getCategory->name;
            })
            ->addColumn('getHrDetails',function(Interview $interviewer){
                // return $interviewer->getHrDetails->map(function($post) {
                    return $interviewer->getHrDetails->name;
                // });
            })
            ->addColumn('action', function($row){
                $btn = '<div class="d-flex justify-content-around align-items-center"><a href="'.route('admincandidate.show',$row->id).'" class="edit mr-3"><i class="fa fa-eye"></i></a>';
                $btn = $btn.'<button class="btn deleteCandidate" data-id="'.$row->id.'"><i class="fa fa-trash"></i></button>';
                $btn = $btn.'<a href="'.route('admincandidate.edit',$row->id).'" class="edit mr-3"><i class="fa fa-edit"></i></a></div>';
                return $btn;
            })->rawColumns(['action','category'])->make(true);
        }
        $category = Category::get();
        return view('admin.candidate.index',compact('category'));
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
        try
        {
            $hrfulldetails=Interview::findOrFail($id);
        }
        catch(Exception $exception)
        {
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
        try {
            $hrfulldetails = Interview::findOrFail($id);
            $category=Category::get();
        } catch (Exception $exception) {
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
        // try
        // {
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
                return redirect()->route('admincandidate.index')->with('success','Interview Updated successfully...!');
            }
        // }
        // catch(Exception $exception)
        // {
        //     throw new \App\Exceptions\UserNotFoundException('Candidate not found');
        // }
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
            if($result>0)
            {
                $msg['msg']="Not Delete Beacuse candidate is exist";
                $msg['status']="false";
                return json_encode($msg);
            }
            else{
                Category::findorfail($id)->delete();
                $msg['msg']="Category Deleted";
                $msg['status']="true";
                return json_encode($msg);
            }
        }
        catch(Exception $ex)
        {
            throw new \App\Exceptions\UserNotFoundException('Candidate counld not be deleted');
        }
    }
}
