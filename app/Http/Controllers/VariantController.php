<?php

namespace App\Http\Controllers;

use App\Http\Requests\VariantRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Variant;
use Yajra\DataTables\Facades\DataTables;

class VariantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $query = Variant::all();
        // dd($query);
        // $dataTables = DataTables::of($query)
            
        // ->toJson();
        // dd($dataTables);
        if (request()->ajax()) {
            $query = Variant::all();

            // dd($query);

            return DataTables::of($query)
                ->addColumn('action', function ($item) {
                    return '
                    <a class="inline-block border border-gray-700 bg-gray-700 text-black rounded-md px-2 py-1 m-1 transition duration-500 ease select-none hover:bg-gray-800 focus:outline-none focus:shadow-outline" 
                        href="' . route('dashboard.variant.edit', $item->id) . '">
                        Edit
                    </a>
                    <form class="inline ml-2" action="' . route('dashboard.variant.destroy', $item->id) . '" method="POST">
                    <button class="border border-red-500 bg-red-500 text-white rounded-md px-2 py-1 m-2 transition duration-500 ease select-none hover:bg-red-600 focus:outline-none focus:shadow-outline" >
                        Hapus
                    </button>
                        ' . method_field('delete') . csrf_field() . '
                    </form>';
                })
                ->editColumn('product_id', function($name) {
                    return $name->product->name;
                })
                ->rawColumns(['action'])
                ->make();
        }
        return view('pages.dashboard.variant.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $id)
    {
        $products = Product::all();
        return view('pages.dashboard.variant.create', compact('products', 'id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VariantRequest $request, $id)
    {
        // dd($id);

        $data = $request->all();
        
        Variant::create($data);

        return redirect()->route('dashboard.variant.show', $id)->with('success', 'variant has been created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $query = Variant::where('product_id', $id)->get();

        if (request()->ajax()) {
            return DataTables::of($query)
                ->addColumn('action', function ($item) {
                    return '
                    <a class="inline-block border border-gray-700 bg-gray-700 text-black rounded-md px-2 py-1 m-1 transition duration-500 ease select-none hover:bg-gray-800 focus:outline-none focus:shadow-outline" 
                        href="' . route('dashboard.variant.edit', $item->id) . '">
                        Edit
                    </a>
                    <form class="inline ml-2" action="' . route('dashboard.variant.destroy', $item->id) . '" method="POST">
                    <button class="border border-red-500 bg-red-500 text-white rounded-md px-2 py-1 m-2 transition duration-500 ease select-none hover:bg-red-600 focus:outline-none focus:shadow-outline" >
                        Hapus
                    </button>
                        ' . method_field('delete') . csrf_field() . '
                    </form>';
                })
                ->editColumn('product_id', function($name) {
                    return $name->product->name;
                })
                ->rawColumns(['action'])
                ->make();
        }

        return view('pages.dashboard.variant.show', compact('id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $variant = Variant::findOrFail($id);

        $product_id = $variant->product_id;

        return view('pages.dashboard.variant.edit', compact('variant', 'product_id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(VariantRequest $request, $id)
    {
        $variant = Variant::findOrFail($id);

        $data = $request->all();
        
        $variant->update($data);

        return redirect()->route('dashboard.variant.show', $variant->product_id)->with('success', 'variant has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $variant = Variant::findOrFail($id);

        $product_id = $variant->product_id;

        $variant->delete();

        return redirect()->route('dashboard.variant.show', $product_id);
    }
}
