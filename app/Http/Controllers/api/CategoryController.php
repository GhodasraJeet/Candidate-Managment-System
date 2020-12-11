<?php

namespace App\Http\Controllers\api;

use Exception;
use App\Category;
use App\Interview;
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
        $category=Category::orderBy('id','desc')->paginate(10);
        if (is_null($category)) {
            return $this->sendError('Category not found.');
        }
        return $this->sendResponse($category, 'Category retrieved successfully.');
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
    public function update(Request $request, $id)
    {
        $input = $request->all();
        $category = Category::findOrFail($id);
        $validator = Validator::make($input, [
            'name' => 'required|unique:category,name,'.$id
        ],
        [
            "name.unique"=>"$request->name Email is alerady taken "
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $category->update($request->all());
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
        try
        {
            if(Interview::where('category_id',$id)->count()>0)
            {
                return $this->sendError('Category could not delete candidate is exists.');
            }
            $category=Category::destroy($id);
            return $this->sendResponse($category,'Category deleted successfully.');
        }
        catch(Exception $exception)
        {
            return $this->sendResponse($category, 'Category could not delete.');

        }

    }
}
