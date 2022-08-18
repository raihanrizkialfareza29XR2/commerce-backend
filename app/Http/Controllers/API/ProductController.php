<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function all(Request $request)
    {
        $id = $request->input('id');
        $limit = $request->input('limit', 6);
        $name = $request->input('name');
        $description = $request->input('description');
        $tags = $request->input('tags');
        $categories = $request->input('categories');
        $price_from = $request->input('price_from');
        $price_to = $request->input('price_to');

        if ($id) {
            $product = Product::with(['category', 'galleries'])->find($id);

            if ($product) {
                return ResponseFormatter::success($product, 'data produk berhasil di ambil');
            } else {
                return ResponseFormatter::error(null, 'data produk tidak ada', 404);
            }
        }

        $product = Product::with(['category', 'galleries']);

        if ($name) {
            $product->where('name', 'like', '%' . $name . '%');
        }
        if ($description) {
            $product->where('description', 'like', '%' . $description . '%');
        }
        if ($tags) {
            $product->where('tags', 'like', '%' . $tags . '%');
        }
        if ($price_from) {
            $product->where('price', '>=', $price_from);
        }
        if ($price_to) {
            $product->where('name', '<=', $price_to);
        }
        if ($categories) {
            $product->where('categories', $categories);
        }

        return ResponseFormatter::success($product->paginate($limit), 'data produk berhasil di ambil');
    }
    public function store(Request $request) 
    { 
        try {
            $data = $request->all();

            Product::create($data);
            
            $product = Product::latest()->first();

            return ResponseFormatter::success([
                'product' => $product
            ], 'Product berhasil dibuat');
        } catch (Exception $error) {
            dd($error);
            return ResponseFormatter::error([
                'message' => 'Something when wrong',
                'error' => $error
            ], 'Gagal membuat produk', 500);
        }
    }
    
    public function updateProduct(Request $request, $id) 
    { 
        // dd($request);
        try {
            // $id = $request->input('id');

            $product = Product::where('id', $id)->first();

            $data = $request->all();
            // dd($data);

            $product->update($data);
            
            $product = Product::where('id', $id)->first();
            
            return ResponseFormatter::success([
                'product' => $product
            ], 'Product berhasil update');
        } catch (Exception $error) {
            dd($error);
            return ResponseFormatter::error([
                'message' => 'Something when wrong',
                'error' => $error
            ], 'Gagal update produk', 500);
        }
    }
    public function deleteProduct(Request $request, $id) 
    { 
        // dd($request);
        try {
            // $id = $request->input('id');

            Product::where('id', $id)->delete();
            
            $products = Product::all();
            
            return ResponseFormatter::success([
                'product' => $products
            ], 'Berhasil menghapus Product');
        } catch (Exception $error) {
            dd($error);
            return ResponseFormatter::error([
                'message' => 'Something when wrong',
                'error' => $error
            ], 'Gagal hapus produk', 500);
        }
    }
}
