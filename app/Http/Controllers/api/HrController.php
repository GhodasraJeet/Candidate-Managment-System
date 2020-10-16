<?php

namespace App\Http\Controllers\api;

use App\User;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HrController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $interview=User::with('getCandidate')->get();
        if (is_null($interview)) {
            return $this->sendError('HR not found.');
        }
        return $this->sendResponse($interview->toArray(), 'HR retrieved successfully.');

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
            $interview = User::create($request->all());
        }
        catch(Exception $exception)
        {
            return $this->sendError($exception->getMessage());
        }
        return $this->sendResponse($interview->toArray(), 'HR saved successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $interview=User::with('getCandidate')->find($id);
        if (is_null($interview)) {
            return $this->sendError('HR not found.');
        }
        return $this->sendResponse($interview->toArray(), 'HR retrieved successfully.');

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
            $interview = User::findOrFail($id);
            if(User::where('email',$request->email)->count()>0){
                return $this->sendError('Validation Error.', ['Email is already taken']);
            }
            $interview->update($request->all());
        }
        catch(Exception $exception)
        {
            return $this->sendError('HR not found.');
        }

        return $this->sendResponse($interview->toArray(), 'HR updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $candidate=User::destroy($id);
        if ($candidate) {
            return $this->sendError('HR deleted successfully.');
        }
        else
        {
            return $this->sendResponse($candidate, 'HR could not delete.');
        }
    }
}
