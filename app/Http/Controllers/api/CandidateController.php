<?php

namespace App\Http\Controllers\api;

use App\Interview;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\api\BaseController;
use Exception;

class CandidateController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $interview=Interview::with('getHrDetails','getCategory')->get();
        if (is_null($interview)) {
            return $this->sendError('candidate not found.');
        }
        return $this->sendResponse($interview->toArray(), 'Candidate retrieved successfully.');
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
            $interview = Interview::create($request->all());
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
