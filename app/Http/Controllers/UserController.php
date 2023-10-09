<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $this->validate($request, [
            'phone_number' => 'required|unique:users',
            'password' => 'required|min:6',
        ]);

        $user = new User();
        $user->phone_number = $request->phone_number;
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json(['message' => 'User registered successfully']);
    }
}
