<?php

namespace App\Http\Controllers\API;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\PasswordReset;
use Laravel\Passport\HasApiTokens;

class UserController extends Controller
{
    public $successStatus = 200;
    /**
     * login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 400);
        }
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
          $user = Auth::user();
          $success['token'] = $user->createToken('authToken')->accessToken;
          return response()->json([
            'success' => true,
            'token' => $success,
            'user' => Auth::user()
          ]);
        }
        else {
          return response()->json([
            'success' => false,
            'message' => 'Invalid Email or Password',
        ], 401);
        }
    }
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        // dd($request->input());
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'role'=>'required_if:admin,hr',
            'c_password' => 'required|same:password',
        ]);

		$input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')->accessToken;
        $success['name'] =  $user->name;
		return response()->json(['success'=>$success], $this-> successStatus);
    }

    public function logout(Request $request)
    {
        $user = Auth::user()->token();
$user->revoke();
    	// $user=Auth::user();
        // $user->token()->revoke();

        return response()->json([
          'success' => true,
          'message' => 'Logout successfully'
      ]);
      // }else {
        return response()->json([
          'success' => false,
          'message' => 'Unable to Logout'
        ]);
      // }

    }
}
