<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Customer; // Import the Customer model

class OrderController extends Controller
{
    public function index(Request $request)
    {
        // Custom authentication logic: Retrieve the authenticated customer based on your phone number and password logic
        // For example, you can use the provided phone number in the request
        $phoneNumber = $request->input('phone_number');
        $password = $request->input('password');

        // Validate the credentials and retrieve the authenticated customer
        $authenticatedCustomer = Customer::where('phone_number', $phoneNumber)->first();
        if (!$authenticatedCustomer || !password_verify($password, $authenticatedCustomer->password)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Retrieve all orders for the authenticated customer
        $customerOrders = $authenticatedCustomer->orders;

        return response()->json($customerOrders);
    }

    public function show(Request $request, Order $order)
    {
        // Custom authentication logic: Retrieve the authenticated customer based on your phone number and password logic
        // For example, you can use the provided phone number in the request
        $phoneNumber = $request->input('phone_number');
        $password = $request->input('password');

        // Validate the credentials and retrieve the authenticated customer
        $authenticatedCustomer = Customer::where('phone_number', $phoneNumber)->first();
        if (!$authenticatedCustomer || !password_verify($password, $authenticatedCustomer->password)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Check if the authenticated customer is the owner of the order
        if ($order->customer_id !== $authenticatedCustomer->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json($order);
    }
}
