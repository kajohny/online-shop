<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\Customer;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $customer = Customer::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $token = $customer->createToken('auth_token')->plainTextToken;

        return response()->json([
            'customer' => $customer,
            'token' => $token,
        ]);
    }

    public function login(Request $request) 
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $customer = Customer::where('email', $data['email'])->first();

        if (! $customer || ! Hash::check($data['password'], $customer->password)) {
            throw ValidationException::withMessages([
                'email' => ['Wrong email or password'],
            ]);
        }

        $token = $customer->createToken('auth_token')->plainTextToken;

        return response()->json([
            'customer' => $customer,
            'token' => $token,
        ]);
    }
    
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'You logged out']);
    }
}
