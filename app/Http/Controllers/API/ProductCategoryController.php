<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;

class ProductCategoryController extends Controller
{
    public function all(Request $request) 
    { 
        $id = $request->input('id');
        $limit = $request->input('limit');
        $name = $request->input('name');
        $show_product = $request->input('show_product');

        if ($id) {
            $category = ProductCategory::with(['products'])->find($id);
    
            if ($category) {
                return ResponseFormatter::success($category, 'data kategori berhasil di ambil');
            } else {
                return ResponseFormatter::error(null, 'data kategori tidak ada', 404);
            }
        }
        $category = ProductCategory::query();

        if ($name) {
            $category->where('name', 'like', '%' . $name . '%');
        }
        if ($show_product) {
            $category->with('products');
        }

        return ResponseFormatter::success($category->paginate($limit), 'data produk berhasil di ambil');
    }

    public function store(Request $request) 
    { 
        try {
            $data = $request->all();

            ProductCategory::create($data);
            
            $category = ProductCategory::latest()->first();

            return ResponseFormatter::success([
                'product' => $category
            ], 'Category Product berhasil dibuat');
        } catch (Exception $error) {
            dd($error);
            return ResponseFormatter::error([
                'message' => 'Something when wrong',
                'error' => $error
            ], 'Gagal membuat category produk', 500);
        }
    }
    
    public function updateProduct(Request $request, $id) 
    { 
        // dd($request);
        try {
            // $id = $request->input('id');

            $category = ProductCategory::where('id', $id)->first();

            $data = $request->all();
            // dd($data);

            $category->update($data);
            
            $category = ProductCategory::where('id', $id)->first();
            
            return ResponseFormatter::success([
                'category' => $category
            ], 'Category Product berhasil update');
        } catch (Exception $error) {
            dd($error);
            return ResponseFormatter::error([
                'message' => 'Something when wrong',
                'error' => $error
            ], 'Gagal update category produk', 500);
        }
    }
    public function deleteProduct(Request $request, $id) 
    { 
        // dd($request);
        try {
            // $id = $request->input('id');

            ProductCategory::where('id', $id)->delete();
            
            $categories = ProductCategory::all();
            
            return ResponseFormatter::success([
                'product' => $categories
            ], 'Berhasil menghapus Category Product');
        } catch (Exception $error) {
            dd($error);
            return ResponseFormatter::error([
                'message' => 'Something when wrong',
                'error' => $error
            ], 'Gagal hapus category produk', 500);
        }
    }
}
