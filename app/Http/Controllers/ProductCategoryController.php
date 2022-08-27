<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductCategoryRequest;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use Yajra\DataTables\Facades\DataTables;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $query = ProductCategory::all();
        // $dataTables = DataTables::of($query)
            
        // ->toJson();
        // dd($dataTables);
        if (request()->ajax()) {
            $query = ProductCategory::all();

            return DataTables::of($query)
                ->addColumn('action', function ($item) {
                    return '
                    <a class="inline-block border border-gray-700 bg-gray-700 text-black rounded-md px-2 py-1 m-1 transition duration-500 ease select-none hover:bg-gray-800 focus:outline-none focus:shadow-outline" 
                        href="' . route('dashboard.category.edit', $item->id) . '">
                        Edit
                    </a>
                    <form class="inline ml-2" action="' . route('dashboard.category.destroy', $item->id) . '" method="POST">
                    <button class="border border-red-500 bg-red-500 text-white rounded-md px-2 py-1 m-2 transition duration-500 ease select-none hover:bg-red-600 focus:outline-none focus:shadow-outline" >
                        Hapus
                    </button>
                        ' . method_field('delete') . csrf_field() . '
                    </form>';
                })
                ->editColumn('parent', function($name) {
                    if ($name->parent != null) {
                        return $name->parent->name;
                    } else {
                        return 'Parent Category';
                    }
                })
                ->rawColumns(['action'])
                ->make();
        }

        return view('pages.dashboard.category.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = ProductCategory::all();
        return view('pages.dashboard.category.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductCategoryRequest $request)
    {
        $data = $request->all();
        
        ProductCategory::create($data);

        return redirect()->route('dashboard.category.index')->with('success', 'Category has been created');
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
        $categories = ProductCategory::where('id', 'NOT LIKE', '%' . $id . '%')->get();
        $category = ProductCategory::findOrFail($id);
        return view('pages.dashboard.category.edit', compact('categories', 'category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductCategoryRequest $request, $id)
    {
        $category = ProductCategory::findOrFail($id);

        $data = $request->all();
        
        $category->update($data);

        return redirect()->route('dashboard.category.index')->with('success', 'Category has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
