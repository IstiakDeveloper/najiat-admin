<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user(); // Fetch the authenticated user
        return response()->json([
            'user' => $user,
            'message' => 'User information retrieved successfully',
        ]);;
    }   
}
