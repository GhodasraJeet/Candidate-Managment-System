<?php

namespace App\Http\Controllers;

use App\Category;
use App\Interview;
use App\User;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminHrController extends Controller
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
            if(!empty($request->from_date))
            {
                $hrfulldetails=User::with('getCandidate')->where('role','hr')->whereBetween('created_at', array($request->from_date, $request->to_date))->get();
            }
            else
            {
                $hrfulldetails=User::with('getCandidate')->where('role','hr')->get();
            }

            return datatables()->of($hrfulldetails)
            ->addColumn('action', function($row){
                $btn = '<div class="d-flex justify-content-around align-items-center"><a href="'.route('hr.show',$row->id).'" class="edit mr-3"><i class="fa fa-eye"></i></a>';
                $btn = $btn.'<button class="btn deleteHr" data-id="'.$row->id.'"><i class="fa fa-trash"></i></button>';
                $btn = $btn.'<a href="'.route('hr.edit',$row->id).'" class="edit mr-3"><i class="fa fa-edit"></i></a></div>';
                return $btn;
            })->rawColumns(['action'])->make(true);
        }
        return view('admin.hrdetails');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.createhr');
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
                "hrname" => "required|string",
                "hremail" => "required|unique:users,email|email",
                "password" => "required|confirmed|max:20|min:8"
            ]
        );
        $user = User::create([
            'name' => $request->hrname,
            'email' => $request->hremail,
            'password' => Hash::make($request->password),
            'remember_token' => Str::random(60),
            'role' => "hr"
        ]);
        if($user)
        {
            return redirect('hr')->with('success','Hr added Successfully...!');
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
            $hrfulldetails=User::with('getCandidate')->where('role','hr')->findOrFail($id);
        }
        catch(Exception $exception)
        {
            throw new \App\Exceptions\UserNotFoundException('HR not found');

        }
        return view('admin.showhr',compact('hrfulldetails'));

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
            throw new \App\Exceptions\UserNotFoundException('HR not found');
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
        try
        {
            $result=User::where('role','hr')->where('id',$id)
            ->update(['name' => $request->hrname,'email'=>$request->hremail]);
            if($result)
            {
                return redirect('hr')->with('success','HR Updated successfully...!');
            }
        }
        catch(Exception $exception)
        {
            throw new \App\Exceptions\UserNotFoundException('HR counld not be updated');
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
            User::where('role','hr')->where('id',$id)->delete();
        }
        catch(Exception $ex)
        {
            throw new \App\Exceptions\UserNotFoundException('HR counld not be deleted');
        }
    }

    public function candidate()
    {
        $category=Category::get();
        $hr=User::where('role','hr')->get();
        return view('admin.candidatelist',compact('category','hr'));
    }

    public function searchcandidate(Request $request)
    {
        if($request->candidate_category=="all")
        {
            $interview=Interview::with('getHrDetails')->get();
        }
        else
        {
            $interview=Interview::with('getHrDetails')->where('category_id',$request->candidate_category)->get();
        }
        return view('admin.candidatesearchlist',compact('interview'));
    }

    public function searchhr(Request $request)
    {
        if($request->hr_list=="all")
        {
            $interview=User::get();
        }
        else
        {
            $interview=User::with('getCandidate')->where('id',$request->hr_list)->get();
        }
        return view('admin.candidatehrlist',compact('interview'));
    }

    public function candidateSingle($canidate_id)
    {
        try
        {
            $candidate=Interview::with('getHrDetails')->findOrFail($canidate_id);
        }
        catch(Exception $exception)
        {
            throw new \App\Exceptions\UserNotFoundException('Candidate not found');
        }
        return view('admin.singlecandidate',compact('candidate'));

    }
}
