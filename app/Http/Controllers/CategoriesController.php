<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;


class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $categories = Category::where('parent_id',0)->orderBy('id')->get(); 
        return view('categories',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
            $this->validate($request, [
                'name' => 'required',
            ]);
            $input = $request->all();
            $input['parent_id'] = empty($input['parent_id']) ? 0 : $input['parent_id'];
            
            Category::create($input);
            return back()->with('success', 'New Category added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $category->name = $request->get('name');
         $category->save();

        
       //  $cat->save(); 
         return redirect()->route('category.index')->with('success','Category update successfully!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        if( $category){
              //check if category assign to sub category 
              if($category->childs->count()){
                  $category->where('parent_id',$category->id)->delete(); 
              }else{
                  $category->delete(); 
              }  
              return redirect()->route('category.index')->with('success','Category delete successfully!');
        }else{  
            return redirect()->route('category.index')->with('error','Something  wrong...');
        }
        
        
    }

    public function getSubCategoryByCategoryId(Request $request){
        if($request->ajax()){
            $catId = $request->input('id');
            $categories = Category::getSubCategoriesByCatId($catId); 
            return response()->json($categories);
        }else{
             return false;
        } 
    } 
        
}
