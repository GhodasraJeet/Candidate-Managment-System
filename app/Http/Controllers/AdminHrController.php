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
        if($request->ajax())
        {
            $page=$request->page;
            $ch = curl_init();
            $hr = Curl::to('http://localhost/candidate/public/api/hr?page=$page')
            ->withBearer($user['token']['token'])
            ->asJson()
            ->get();

            $current_page=$hr->data->current_page;
            $prev_page=$hr->data->prev_page_url;
            $last_page=$hr->data->last_page;
            $next_page=$hr->data->next_page_url;
            $per_page=$hr->data->per_page;
            $total=$hr->data->total;

            $data['data']=$hr->data->data;
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
            $hr = Curl::to('http://localhost/candidate/public/api/hr')
            ->withBearer($user['token']['token'])
            ->asJson()
            ->get();
            $current_page=$hr->data->current_page;
            $first_page=$hr->data->first_page_url;
            $last_page=$hr->data->last_page;
            $next_page=$hr->data->next_page_url;

            $data['data']=$hr->data->data;
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
        $data=[
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>$request->password,
            'role'=>'hr'
        ];
        $output = Curl::to('http://localhost/candidate/public/api/hr')
        ->withBearer($user['token']['token'])
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
        $hr_id=$request->hrid;
        $hr = Curl::to('http://localhost/candidate/public/api/hr/'.$hr_id)
        ->withBearer($user['token']['token'])
        ->get();
        return response()->json($hr,200);
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
        $data=['name'=>$request->name,'email'=>$request->email];
        $response = Curl::to("http://localhost/candidate/public/api/hr/$request->id")
        ->withData($data)
        ->withBearer($user['token']['token'])
        ->patch();
        return response()->json($response,200);
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
        $hr_id=$request->hrid;
        $response = Curl::to("http://localhost/candidate/public/api/hr/$hr_id")
        ->withBearer($user['token']['token'])
        ->delete();
        return response()->json($response,200);
    }
}
