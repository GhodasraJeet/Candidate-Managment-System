<?php

namespace App\Http\Controllers\api;

use Exception;
use App\Interview;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\api\BaseController;

class CandidateController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $interview=Interview::with('getHrDetails','getCategory')->paginate(10);
        if (is_null($interview)) {
            return $this->sendError('candidate not found.');
        }
        return $this->sendResponse($interview, 'Candidate retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try
        {
            $input = $request->all();
            $validator = Validator::make($input, [
                'name'=>'required',
                'email' => 'required|unique:interview,email',
                'phone'=>'required|min:10',
                'other_phone'=>'required|min:10',
                'category_id'=>'required',
                'experience'=>'required|numeric|max:3',
                'currnet_salary'=>'required|number'
            ],
            [
                "email.unique"=>"$request->name is alerady existed"
            ]);
            if($validator->fails()){
                return $this->sendError('Validation Error.', $validator->errors());
            }
            $interview = Interview::create($input);
        }
        catch(Exception $exception)
        {
            return $this->sendError($exception->getMessage());
        }
        return $this->sendResponse($interview->toArray(), 'Candidate saved successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $interview=Interview::with('getHrDetails','getCategory')->find($id);
        if (is_null($interview)) {
            return $this->sendError('Candidate not found.');
        }
        return $this->sendResponse($interview->toArray(), 'Candidate retrieved successfully.');
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
            $input = $request->all();
            $interview = Interview::findOrFail($id);
            if(Interview::where('email',$request->email)->count()>0){
                return $this->sendError('Validation Error.', ['Email is already taken']);
            }
            $interview->update($request->all());
        }
        catch(Exception $exception)
        {
            return $this->sendError('Candidate not found.');
        }

        return $this->sendResponse($interview->toArray(), 'Candidate updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $candidate=Interview::destroy($id);
        if ($candidate) {
            return $this->sendError('Candidate deleted successfully.');
        }
        else
        {
            return $this->sendResponse($candidate, 'Candidate could not delete.');
        }
    }
}
