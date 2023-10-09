<?php

// app/Http/Controllers/Auth/RegistrationController.php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegistrationController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone_number' => 'required|unique:customers',
            'email' => 'required|email|unique:customers',
            'password' => 'required|min:6',
        ]);

        $customer = Customer::create([
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return response()->json($customer, 201);
    }


    public function login(Request $request)
    {
        $credentials = $request->only('phone_number', 'password');

        if (Auth::guard('customer')->attempt($credentials)) {
            // Authentication successful
            return response()->json(['message' => 'Login successful'], 200);
        } else {
            // Authentication failed
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
}

}
