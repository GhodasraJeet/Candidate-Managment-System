<?php

namespace App\Http\Controllers;

use Exception;
use App\Category;
use App\Interview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class HrCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $params=$request->params;
        if($request->ajax())
        {
            if(!empty($request->from_date))
            {
                $query=Category::whereBetween('created_at', array($request->from_date, $request->to_date))->get();
            }
            else
            {
                $query=Category::latest()->get();
            }

            return datatables()->of($query)->addIndexColumn()
            ->addColumn('action', function($row){

                $btn = '<div class="d-flex justify-content-around align-items-center"><a href="'.route('hrcategory.show',$row->id).'" class="edit mr-3"><i class="fa fa-eye"></i></a>';
                $btn = $btn.'<button class="btn deleteCategory" data-id="'.$row->id.'"><i class="fa fa-trash"></i></button>';
                $btn = $btn.'<a href="'.route('hrcategory.edit',$row->id).'" class="edit mr-3"><i class="fa fa-edit"></i></a></div>';

                return $btn;
            })->rawColumns(['action'])->make(true);
        }

        return view('hr.category_details');
        // $categoryDetails=Category::get();
        // return view('hr.category_details',compact('categoryDetails'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('hr.create_category');
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
                "categoryname" => "required|string|unique:category,name",
            ]
        );
        $category=new Category;
        $category->name=$request->categoryname;
        if($category->save())
        {
            return redirect()->route('hrcategory.index')->with('success','Category added Successfully...!');
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
            $categoryfulldetails=Category::findorfail($id);
        }
        catch(Exception $exception)
        {
            throw new \App\Exceptions\UserNotFoundException('Category not found');
        }
        return view('hr.show_category',compact('categoryfulldetails'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
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
            throw new \App\Exceptions\UserNotFoundException('Category not found');
        }
        return view('hr.edit_category',compact('categoryfulldetails'));
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
            $result=Category::find($id)
            ->update(['name' => $request->categoryname]);
            if($result)
            {
                return redirect()->route('hrcategory.index')->with('success','Category Updated successfully...!');
            }
        }
        catch(Exception $exception)
        {
            throw new \App\Exceptions\UserNotFoundException('Category not found');
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
            $result=Interview::where('category_id',$id)->count();
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
            throw new \App\Exceptions\UserNotFoundException('Category not found');
        }
        // return redirect()->route('hrcategory.index')->with('warning','Category Deleted suceesfully....');
    }
}
