<?php

namespace App\Http\Controllers\api;

use App\User;
use Exception;
use App\Jobs\NewUser;
use App\Jobs\sendmail;
use App\Jobs\SendEmailJob;
use Illuminate\Http\Request;
use App\Jobs\NewUserRegister;
use App\Jobs\SendWelcomeEmail;
use App\Mail\RegisterUserMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class HrController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $interview=User::orderBy('id','desc')->where('role','hr')->paginate(10);
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
            $input = $request->all();
            $validator = Validator::make($input, [
                'email' => 'required|unique:users,email',
                'name'=>'required',
                'password'=>'required',
                'role'=>'required|in:admin,hr'
            ],
            [
                "name.unique"=>"$request->name Category is alerady existed"
            ]);
            if($validator->fails()){
                return $this->sendError('Validation Error.', $validator->errors());
            }
            $hr = User::create($input);
            NewUser::dispatch($hr)->delay(now()->addMinutes(1));
        }
        catch(Exception $exception)
        {
            return $this->sendError($exception->getMessage());
        }
        return $this->sendResponse($hr->toArray(), 'HR saved successfully.');
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
            $interview=User::with('getCandidate')->find($id);
            if (is_null($interview)) {
                return $this->sendError('HR not found.');
            }
            return $this->sendResponse($interview->toArray(), 'HR retrieved successfully.');

        }
        catch(Exception $exception)
        {
            return $this->sendError($exception->getMessage());
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
            $input = $request->all();
            $interview = User::findOrFail($id);
            $validator = Validator::make($input, [
                'email' => 'unique:users,email,'.$id,
            ],
            [
                "email.unique"=>"$request->email Email is alerady taken "
            ]);
            if($validator->fails()){
                return $this->sendError('Validation Error.', $validator->errors());
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
        try
        {
            $candidate=User::destroy($id);
            return $this->sendResponse($candidate,'HR deleted successfully.');
        }
        catch(Exception $exception)
        {
            return $this->sendError($candidate, 'HR could not delete.');
        }
    }
}
