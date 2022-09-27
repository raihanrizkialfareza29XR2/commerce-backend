<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CheckoutController extends Controller
{
    public function placeorder(Request $request) 
    { 
        if (Auth::check()) {
            $validator = Validator::make($request->all(), [
                'firstname' => 'required|max:255',
                'lastname' => 'required|max:255',
                'phone' => 'required|max:255',
                'email' => 'required|max:255',
                'address' => 'required|max:255',
                'zipcode' => 'required|max:255',
                'courier' => 'required|max:255',
                'payment_method' => 'required|max:255',
            ]);

            if ($validator->fails()) {
                return ResponseFormatter::error([
                    'message' => 'Something when wrong',
                    'error' => $validator->messages()
                ], 422);
            } else {
                $user_id = Auth::id();
                // dd((float)$request->total_price);
                $transaction = Transaction::create([
                    'users_id' => $user_id,
                    'firstname' => $request->firstname,
                    'lastname' => $request->lastname,
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'address' => $request->address,
                    'zipcode' => $request->zipcode,
                    'courier' => $request->courier,
                    'payment_method' => $request->payment_method,
                    'total_price' => (float)$request->total_price,
                    'shipping_price' => (float)$request->shipping_price,
                ]);

                $cart = Cart::where('user_id', $user_id)->get();
                $transactionId = Transaction::where('users_id', $user_id)->latest()->first();

                $cartItems = [];

                foreach ($cart as $item) {
                    $cartItems[] = [
                        'users_id' => $user_id,
                        'transactions_id' => $transactionId,
                        'products_id' => $item->product_id,
                        'quantity' => $item->quantity,
                    ];
                }

                $transaction->orderItems()->createMany($cartItems);
                Cart::destroy($cart);

                return ResponseFormatter::success([
                    'message' => 'Order Placed Success'
                ], 200);
            }
        } else {
            return ResponseFormatter::error([
                'message' => 'You are not logged in',
            ], 'Unathorized', 500);
        }
    }

    public function confirmPayment(Request $request, $id) 
    { 
        $image = $request->file('foto');

        if (empty($image)) {
            return ResponseFormatter::error([
                'message' => 'No File Uploaded',
            ], 'Payemnt Un-confirmed', 500);
        } else {
            $transaction = Transaction::where('id', $id)->first();

            $transaction->update([
                'status' => 'CONFIRMED'
            ]);

            return ResponseFormatter::success([
                'message' => 'Success Confirm Payment, Please wait for a patient time',
            ], 'Success', 200);
        }
        
    }
    
}
