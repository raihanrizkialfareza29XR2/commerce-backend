<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use Laravel\Fortify\Rules\Password;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class UserController extends Controller
{
    public function register(Request $request) 
    {
        try {
            $val = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'username' => ['required', 'string', 'max:255', 'unique:users'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'phone' => ['required', 'string', 'max:255'],
                'password' => ['required', 'string'],
            ]);

            // $vali = dd($val);
            // return response()->json($val);
            // dd($val);

            User::create([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'phone_number' => $request->phone,
                'password' => bcrypt($request->password),
            ]);
            

            $user = User::where('email', $request->email)->first();

            $tokenResult = $user->createToken('authToken')->plainTextToken;

            return ResponseFormatter::success([
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user,
            ], 'User Registered');
        } catch (Exception $error) {
            $val = $request->all;
            dd($request->all);
            // $vali = $val.toArray();
            // return response()->json($val);
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => $error
            ], 'Auth Failed', 500);
        }
    }

    public function googleLogin() 
    { 
        return Socialite::driver('google')->redirect();
    }

    public function googleCallback() 
    {
        try {
            $data = Socialite::driver('google')->user();
            $user = User::where('email', $data->email)->first();
            if ($user) {
                Auth::login($user);
                $tokenResult = $user->createToken('authToken')->plainTextToken;
                return ResponseFormatter::success([
                    'access_token' => $tokenResult,
                    'token_type' => 'Bearer',
                    'user' => $user,
                ],'Success Login', 200);
            } else {
                $regist = User::create([
                    'name' => ucwords($data->name),
                    'email' => $data->email,
                    'email_verified_at' => now(),
                    'password' => bcrypt('defaultPassword'),
                    'remember_token' => Str::random(10),
                ]);

                $tokenResult = $regist->createToken('authToken')->plainTextToken;
                Auth::login($regist);
                return ResponseFormatter::success([
                    'access_token' => $tokenResult,
                    'token_type' => 'Bearer',
                    'user' => $user,
                ],'Success Login and Register', 200);
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function login(Request $request) 
    { 
        try {
            $request->validate([
                'email' => ['required', 'string', 'email', 'max:255'],
                'password' => ['required', 'string'],
            ]);
    
            $credentials = request(['email', 'password']);
            if (!Auth::attempt($credentials)) {
                return ResponseFormatter::error([
                    'message' => 'Unauthorized'
                ], 'Authentication Failed', 500);
            }
    
            $user = User::where('email', $request->email)->first();
    
            if (! Hash::check($request->password, $user->password, [])) {
                throw new \Exception('Invalid Credentials');
            }
    
            $tokenResult = $user->createToken('authToken')->plainTextToken;
            return ResponseFormatter::success([
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user
            ], 'Authorized');
        } catch (Exception $error) {
            dd($error);
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => $error
            ], 'Auth Failed', 500);
        }
    }
    
    public function fetch(Request $request) 
    { 
        return ResponseFormatter::success($request->user(), 'Data profile berhasi di ambil');
    }
    
    public function logout(Request $request) 
    { 
        Auth::logout();
        return ResponseFormatter::success('Token Revoked');
    }

    public function updateUser(Request $request) 
    { 
        $data = $request->all();

        $user = Auth::user();

        $user->update($data);

        return ResponseFormatter::success($user, 'Profile Updated');
    }
}
