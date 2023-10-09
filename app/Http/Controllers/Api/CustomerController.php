<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;


class CustomerController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone_number' => 'required|unique:customers',
            'password' => 'required|min:6',
        ]);

        $customer = Customer::create([
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'password' => bcrypt($request->password),
        ]);

        return response()->json($customer, 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('phone_number', 'password');

        if (Auth::guard('customer')->attempt($credentials)) {
            $customer = Customer::where('phone_number', $request->phone_number)->first();
            $token = $customer->createToken('customerToken')->plainTextToken;
            return response()->json(['message' => 'Login successful', 'token' => $token], 200);
        } else {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
    }

    public function profile(Request $request)
    {
        return response()->json(['customer' => $request->user()]);
    }
}
