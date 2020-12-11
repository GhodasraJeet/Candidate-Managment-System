<?php

namespace App\Http\Controllers;

use App\User;
use Exception;
use App\Category;
use App\Interview;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;
use Illuminate\Support\Facades\Hash;
use App\Exceptions\UserNotFoundException;

class AdminHrController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.hrdetails');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $user=$request->session()->get('email');
        $token = "Authorization: Bearer ".$user->token->token;

        if($request->ajax())
        {
            $page=$request->page;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "http://localhost/candidate/public/api/hr?page=$page");
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $token ,'Accept: application/json'));
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

            $output = curl_exec($ch);
            $a=json_decode($output);
            curl_close($ch);
            $current_page=$a->data->current_page;
            $prev_page=$a->data->prev_page_url;
            $last_page=$a->data->last_page;
            $next_page=$a->data->next_page_url;
            $per_page=$a->data->per_page;
            $total=$a->data->total;

            $data['data']=$a->data->data;
            $data['current_page']=$current_page;
            $data['next_page']=$next_page;
            $data['last_page']=$last_page;
            $data['per_page']=$per_page;
            $data['prev_page']=$prev_page;
            $data['total']=$total;
            return response()->json($data,200);
        }
        else
        {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "http://localhost/candidate/public/api/hr");
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $token ,'Accept: application/json'));
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

            $output = curl_exec($ch);
            $a=json_decode($output);
            curl_close($ch);
            $current_page=$a->data->current_page;
            $first_page=$a->data->first_page_url;
            $last_page=$a->data->last_page;
            $next_page=$a->data->next_page_url;

            $data['data']=$a->data->data;
            $data['current_page']=$current_page;
            $data['next_page']=$next_page;
            $data['last_page']=$last_page;
            return response()->json($data,200);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user=$request->session()->get('email');
        $token = "Authorization: Bearer ".$user->token->token;
        $data=[
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>$request->password,
            'role'=>'hr'
        ];
        $output = Curl::to('http://localhost/candidate/public/api/hr')
        ->withBearer($user->token->token)
        ->withData($data)
        ->post();
        return response()->json($output,200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $user=$request->session()->get('email');
        $token = "Authorization: Bearer ".$user->token->token;
        $hr_id=$request->hrid;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://localhost/candidate/public/api/hr/$hr_id");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $token ,'Accept: application/json'));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        return response()->json($output,200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $hrfulldetails = User::where('role','hr')->where('id',$id)->firstorfail();
        } catch (Exception $exception) {
            throw new UserNotFoundException('HR not found');
        }
        return view('admin.edithr',compact('hrfulldetails'));
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
        $user=$request->session()->get('email');
        $token = "Authorization: Bearer ".$user->token->token;
        $data=[
            'name'=>$request->name,
            'email'=>$request->email
        ];
        $response=json_encode($data);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://localhost/candidate/public/api/hr/$request->id");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $token ,'Accept: application/json'));
        // curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: ' . strlen($response)));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $response);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        curl_close($ch);
        return response()->json($output,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $user=$request->session()->get('email');
        $token = "Authorization: Bearer ".$user->token->token;
        $hr_id=$request->hrid;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://localhost/candidate/public/api/hr/$hr_id");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $token ,'Accept: application/json'));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        $output = curl_exec($ch);
        curl_close($ch);
    }
}
