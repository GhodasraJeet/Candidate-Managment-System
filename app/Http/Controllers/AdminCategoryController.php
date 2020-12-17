<?php

namespace App\Http\Controllers;

use Exception;
use App\Category;
use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;
use App\DataTables\CategoryDataTable;
use App\Exceptions\UserNotFoundException;

class AdminCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        // return $datatable->render('admin.category.category_details');
        return view('admin.category.category_details');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $user=$request->session()->get('email');
        $token = "Authorization: Bearer ".$user['token']['token'];
        if($request->ajax())
        {
            $page=$request->page;
            $category = Curl::to('http://localhost/candidate/public/api/category?page=$page')
            ->withBearer($user['token']['token'])
            ->asJson()
            ->get();

            $current_page=$category->data->current_page;
            $prev_page=$category->data->prev_page_url;
            $last_page=$category->data->last_page;
            $next_page=$category->data->next_page_url;
            $per_page=$category->data->per_page;
            $total=$category->data->total;

            $data['data']=$category->data->data;
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
            $category = Curl::to('http://localhost/candidate/public/api/category')
            ->withBearer($user['token']['token'])
            ->asJson()
            ->get();

            $current_page=$category->data->current_page;
            $first_page=$category->data->first_page_url;
            $last_page=$category->data->last_page;
            $next_page=$category->data->next_page_url;

            $data['data']=$category->data->data;
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
        $token = "Authorization: Bearer ".$user['token']['token'];
        $data=[
            'name'=>$request->category
        ];
        $category = Curl::to('http://localhost/candidate/public/api/category')
        ->withBearer($user['token']['token'])
        ->withData($data)
        ->post();
        return response()->json($category,200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $user=$request->session()->get('email');
        $token = "Authorization: Bearer ".$user['token']['token'];
        $category_id=$request->categoryid;
        $category = Curl::to('http://localhost/candidate/public/api/category/'.$category_id)
            ->withBearer($user['token']['token'])
            ->get();
        return response()->json($category,200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try
        {
            $categoryfulldetails=Category::findorfail($id);
        }
        catch(Exception $exception)
        {
            throw new UserNotFoundException('Category not found');
        }
        return view('admin.category.edit_category',compact('categoryfulldetails'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user=$request->session()->get('email');
        $data=['name'=>$request->category];
        $response = Curl::to("http://localhost/candidate/public/api/category/$request->id")
        ->withData( $data )
        ->withBearer($user['token']['token'])
        ->patch();
        return response()->json($response,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $user=$request->session()->get('email');
        $category_id=$request->categoryid;
        $response = Curl::to("http://localhost/candidate/public/api/category/$category_id")
        ->withBearer($user['token']['token'])
        ->delete();
        return response()->json($response,200);
    }
}
