<?php

namespace App\Http\Controllers; 
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; 
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Input;
use File;
use App\User; 
use App\Service;
use App\Category;
class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categories = Category::getMainCategoriesPluck(); 
        $subCategories = Category::getAllSubCategoriesPluck();  
        $services = Service::paginate(2);
        $searchParma = $request->input();
         if($searchParma){
            $services = '';
            $searchText = (isset($searchParma['search'])) ? $searchParma['search'] : '';
            $searchCat = (isset($searchParma['category_id'])) ? $searchParma['category_id'] : '';
            $searchSubCat = (isset($searchParma['sub_category_id'])) ? $searchParma['sub_category_id'] : '';
            $searchStartDate = (isset($searchParma['start_time'])) ? $searchParma['start_time'] : '';
           
            $serviceQuery = Service::where(function($q) use($searchText) {
                                 $q-> where('name','LIKE','%'.$searchText.'%')->orWhere('description','LIKE','%'.$searchText.'%');
                             }); 
            if($searchCat){
                $serviceQuery = $serviceQuery->where("category_id",$searchCat);
            }
            if($searchSubCat){
                $serviceQuery = $serviceQuery->where("sub_category_id",$searchSubCat);
            }
            if($searchStartDate){
                $serviceQuery = $serviceQuery->where("start_date",$searchStartDate);
            }

            $services = $serviceQuery->paginate(2)->appends(request()->except('page'));
             
         }
      // dd($services->toArray());
        return view('services.index', compact('services','categories','subCategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    { 
        $categories = Category::getMainCategoriesPluck(); 
        return view('services.create',compact('categories'));
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
            'category_id' => 'required', 
            'sub_category_id' => 'required', 
            'name' => 'required', 
            'start_date' => 'required', 
            'end_date' => 'required', 
            'description' => 'required', 
        ]);
        $service = new Service(); 
        $service->sub_category_id = ( $request->sub_category_id ) ? $request->sub_category_id : $request->category_id;
        $service->category_id = $request->category_id;
        $service->name = $request->name;
        $service->description = $request->description;
        $service->start_date = ($request->start_date) ? $request->start_date : date('y-m-d'); 
        $service->end_date =   ($request->end_date) ? $request->end_date : date('y-m-d');   
        $service->save(); 
        return redirect()->route('services.index')
                        ->with('success','User created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Services  $service
     * @return \Illuminate\Http\Response
     */
    public function show(Service $service)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Services  $service
     * @return \Illuminate\Http\Response
     */
    public function edit(Service $service)
    {
        $item = $service;
         $categories = Category::getMainCategoriesPluck();
         $subCategories = Category::getSubCategoriesPluck($item->categories_id);
       return view('admin.services.edit', compact('item','categories','subCategories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Services  $service
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Service $service)
    {
        $data = $service;
       $this->validate($request, [
            'category_id' => 'required', 
            'sub_category_id' => 'required', 
            'name' => 'required', 
            'start_date' => 'required', 
            'end_date' => 'required', 
            'description' => 'required', 
        ]); 
        $service->sub_category_id = ( $request->sub_category_id ) ? $request->sub_category_id : $request->category_id;
        $service->category_id = $request->category_id;
        $service->name = $request->name;
        $service->description = $request->description;
        $service->start_date = ($request->start_date) ? $request->start_date : date('y-m-d'); 
        $service->end_date =   ($request->end_date) ? $request->end_date : date('y-m-d');   
        $service->save(); 
        session()->flash('success', 'Update Successfully');
        return redirect()->route('services.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Services  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service)
    { 
        $service->delete();
        return redirect()->route('services.index');
    }

    public function getBasicData(Request $request){
        $items = Service::get();
        return Datatables::of($items) 
            ->editColumn('name', function ($item) {
                return $item->name;
            })
            ->editColumn('category', function ($item) {
                return (isset($item) && !empty($item)) ? $item->serviceCategory->name : '';
            })        
            ->addColumn('action', function ($item) {
                $action = '<a href="'.route("services.edit", $item->id).'" class="btn btn-primary btn-flat" style="margin-right:5px;"><i class="fa fa-pencil"></i> Edit</a>';
                $action .= '<form action="'.route("services.destroy", $item->id).'" method="post" style="display:inline-block; vertical-align: middle; margin: 0;" id="'.$item->id.'">
                <input type="hidden" name="_token" value="'.csrf_token().'">
                <input type="hidden" name="_method" value="DELETE">
                <button type="button" data-toggle="modal" data-target="#confirmDelete" data-title="Delete" data-message="Are you sure you want to delete this category?" class="btn btn-danger btn-flat deletebtn deleteLinkButton">Delete</button></form>
                ';
                return $action;
            })
            ->rawColumns(['action'])
            ->make(true);
    }   
}
