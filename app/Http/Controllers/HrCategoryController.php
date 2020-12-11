<?php

namespace App\Http\Controllers;

use Exception;
use App\Category;
use App\Interview;
use Illuminate\Http\Request;
use App\DataTables\CategoryDataTable;
use App\Exceptions\UserNotFoundException;

class HrCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CategoryDataTable $datatable)
    {
        return $datatable->render('hr.category_details');
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
            return redirect()->route('category.index')->with('success','Category added Successfully...!');
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
                return redirect()->route('category.index')->with('success','Category Updated successfully...!');
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
            throw new UserNotFoundException('Category not found');
        }
    }
}
