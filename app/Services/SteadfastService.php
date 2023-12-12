<?php

namespace App\Services;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class SteadfastService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => config('services.steadfast.base_url'),
            'headers'  => [
                'Api-Key'       => config('services.steadfast.api_key'),
                'Secret-Key'    => config('services.steadfast.secret_key'),
                'Content-Type'  => 'application/json',
            ],
        ]);
    }

    public function placeOrder($data)
    {
        try {
            // Making a POST request to create an order
            $response = $this->client->post(config('services.steadfast.base_url') . '/create_order', [
                'json' => $data,
            ]);

            // Process the successful response as needed
            $responseData = json_decode($response->getBody(), true);

            // You may want to log or handle the response data here

            return $responseData;
        } catch (RequestException $e) {
            // Dump the detailed response for debugging purposes
            dd([
                'error' => true,
                'message' => 'Failed to place the order with Steadfast API.',
                'response' => $e->getResponse(), // This will contain detailed information about the error
            ]);

            // Handle the exception, log, display a message, etc.
            // You can access the exception details using $e->getMessage(), $e->getCode(), etc.

            // Log the error, for example
            \Log::error('Steadfast API Error: ' . $e->getMessage());

            // You might want to return a custom error message or response
            return [
                'error' => true,
                'message' => 'Failed to place the order with Steadfast API.',
            ];
        }
    }

    // You can implement other methods for bulk order creation, checking delivery status, getting current balance, etc.
}
