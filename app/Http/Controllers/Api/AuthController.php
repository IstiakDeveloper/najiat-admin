<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function checkAuthentication()
    {
        return response()->json(['authenticated' => auth()->check()]);
    }
}
