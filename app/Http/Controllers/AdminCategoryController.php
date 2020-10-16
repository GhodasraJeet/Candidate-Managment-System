<?php

namespace App\Http\Controllers;

use Exception;
use App\Category;
use App\Interview;
use Illuminate\Http\Request;

class AdminCategoryController extends Controller
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
                $query = Category::whereBetween('created_at', array($request->from_date, $request->to_date))->get();
            }
            else
            {
                $query=Category::get();
            }
            return datatables()->of($query)->addIndexColumn()
            ->addColumn('action', function($row){

                $btn = '<div class="d-flex justify-content-around align-items-center"><a href="'.route('admincategory.show',$row->id).'" class="edit mr-3"><i class="fa fa-eye"></i></a>';
                $btn = $btn.'<button class="btn deleteCategory" data-id="'.$row->id.'"><i class="fa fa-trash"></i></button>';
                $btn = $btn.'<a href="'.route('admincategory.edit',$row->id).'" class="edit mr-3"><i class="fa fa-edit"></i></a></div>';

                return $btn;
            })->rawColumns(['action'])
            ->make(true);
        }

        return view('admin.category.category_details');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.category.create_category');
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
            return redirect()->route('admincategory.index')->with('success','Category added Successfully...!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
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
        return view('admin.category.show_category',compact('categoryfulldetails'));
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
            throw new \App\Exceptions\UserNotFoundException('Category not found');
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
        try
        {
            $result=Category::find($id)
            ->update(['name' => $request->categoryname]);
            if($result)
            {
                return redirect()->route('admincategory.index')->with('success','Category Updated successfully...!');
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
     * @param  \App\Category  $category
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
    }
}
