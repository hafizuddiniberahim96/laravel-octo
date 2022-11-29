<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\Roles;

class AuthController extends Controller
{
    private $role = 'User';
    //
    public function register(Request $request){
        
   
        $post_data = $request->validate([
            'name'=>'required|string',
            'password'=>'required|min:5',
        ]);

        $role= Roles::where('role', $this->role)->firstOrFail();
        $user = User::create([
            'name' => $post_data['name'],
            'role' => $role->id,
            'password' => Hash::make($post_data['password']),
        ]);

        $token = $user->createToken('authToken')->plainTextToken; 
        
        return response()->json([
            'access_token' => $token,
        ]);
    }
    
    public function login(Request $request){
        if (!\Auth::attempt($request->only('name', 'password'))) {
            return response()->json([
                'message' => 'Login information is invalid.'
              ], 401);
        }

        $user = User::where('name', $request['name'])->firstOrFail();
        # BY PASS password just for easy access for interviewer
        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'access_token' => $token,
        ]);
    }
}
