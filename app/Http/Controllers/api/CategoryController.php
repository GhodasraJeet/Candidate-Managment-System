<?php

namespace App\Http\Controllers\api;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\api\BaseController;

class CategoryController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category=Category::get();
        if (is_null($category)) {
            return $this->sendError('Category not found.');
        }
        return $this->sendResponse($category->toArray(), 'Category retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required|unique:category,name',
        ],
        [
            "name.unique"=>"$request->name Category is alerady existed"
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $category = Category::create($input);
        return $this->sendResponse($category->toArray(), 'Category created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::find($id);
        if (is_null($category)) {
            return $this->sendError('Category not found.');
        }
        return $this->sendResponse($category->toArray(), 'Category retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required'
        ]);
        if(category::where('name',$request->name)->count()>0){
            return $this->sendError('Validation Error.', ['Category Name is already taken']);
        }
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $category->name = $input['name'];
        $category->hr_id = $input['hr_id'];
        $category->save();


        return $this->sendResponse($category->toArray(), 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category=Category::destroy($id);
        if ($category) {
            return $this->sendError('Category deleted successfully.');
        }
        else
        {
            return $this->sendResponse($category, 'Category could not delete.');
        }
    }
}
