<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    // Create a new account
    public function register(UserRequest $request){
        $data = [
            "fullname"=>$request->fullname,
            "email"=>$request->email,
            "password"=>Hash::make($request->password),
        ];

        if($user = User::create($data)){
            $token = $user->createToken('MyAppToken')->plainTextToken;
            return response()->json([
                "icon"=>"success",
                "message"=>"The account has successfully created.",
                "id"=>$user->id,
                "token"=>$token
            ],200);
        }
        return response()->json([
            "icon"=>"warning",
            "message"=>"The account has not created !"
        ],401);
    }

    // Login
    public function login(UserRequest $request){
        if(Auth::attempt(['email'=>$request->email,'password'=>$request->password])){
            $user = Auth::user();
            $token = $user->createToken('MySecret')->plainTextToken;
            return response()->json([
                "icon"=>"success",
                "message"=>"You has successfully logged in.",
                "id"=>$user->id,
                "token"=>$token
            ],200);
        }
        return response()->json([
            "icon"=>"warning",
            "message"=>"Email or password is incorrect !"
        ],201);
    }

    // Logout
    public function logout (Request $request) {
        $request->user()->tokens()->delete();
        return response([
            "icon"=>"success",
            "message" => "You have been successfully logged out!"
        ], 200);
    }

    // Profile
    public function profile(Request $request){
        $profile = $request->user();
        return response([
            "icon"=>"success",
            "profile" => $profile
        ], 200);
    }

    // Change password
    public function changePassword(UserRequest $request){
        $user = $request->user();
        if(!Hash::check($request->password, $user->password)){
            return response()->json([
                'icon' => 'warning',
                'message' => 'The last password is incorrect.',
            ], 400);
        }
        $user->password = Hash::make($request->new_password);
        if($user->save()){
            return response([
                "icon"=>"success",
                "message" => "The password has been updated"
            ], 200);
        } else{
            return response([
                "icon"=>"warning",
                "message" => "The password has not been updated"
            ], 200);
        }
    }

    // Update Profile
    public function updateProfile(UserRequest $request){
        $user = $request->user();
        $data = [
            "fullname" => $request->fullname,
            "email" => $request->email,
        ];
        if($user->update($data)){
            return response([
                "icon"=>"success",
                "message" => "The profile has been updated"
            ], 200);
        } else{
            return response([
                "icon"=>"warning",
                "message" => "The profile has not been updated"
            ], 200);
        }
    }
}
