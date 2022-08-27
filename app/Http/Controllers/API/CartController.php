<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use Illuminate\Http\Request;
// use Munna\ShoppingCart\Cart;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function add(Request $request) 
    { 
        if (Auth::check()) {
            $user_id = Auth::id();
            $product_id = $request->product_id;
            $quantity = $request->quantity;

            $productCheck = Product::where('id', $product_id)->first();

            if ($productCheck) {
                if (Cart::where('product_id', $product_id)->where('user_id', $user_id)->exists()) {
                    return ResponseFormatter::error( 'Item Already in cart', 409);
                } else {
                    $create = Cart::create([
                        'user_id' => $user_id,
                        'product_id' => $product_id,
                        'quantity' => $quantity
                    ]);

                    if ($create) {
                        return ResponseFormatter::success('Added Successfully', 201);
                    } else {
                        return ResponseFormatter::error('Error', 403);
                    }
                    
                }
            } else {
                return ResponseFormatter::error('Product Not Found', 404);
            }
        } else {
            return ResponseFormatter::error([
                'message' => 'Unauthorized'
            ], 'You are not logged in', 500);
        }
    }
    
    public function update($id, Request $request) 
    { 
        if (Auth::check()) {
            $user_id = Auth::id();
            $quantity = $request->quantity;

            $cartCheck = Cart::where('id', $id)->first();

            if ($cartCheck) {
                $cart = Cart::findOrFail($id);
                $update = $cart->update([
                    'user_id' => $user_id,
                    'quantity' => $quantity
                ]);

                if ($update) {
                    return ResponseFormatter::success('Updated Successfully', 201);
                } else {
                    return ResponseFormatter::error('Error', 403);
                }
            } else {
                return ResponseFormatter::error('Theres not any cart item with this id', 403);
            }
        } else {
            return ResponseFormatter::error([
                'message' => 'Unauthorized'
            ], 'You are not logged in', 500);
        }
    }

    public function cart() { 
        if (Auth::check()) {
            $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();

            return ResponseFormatter::success($cartItems);
        } else {
            return ResponseFormatter::error([
                'message' => 'Unauthorized'
            ], 'You are not logged in', 500);
        }
        
    }
}
