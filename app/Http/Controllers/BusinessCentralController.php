<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BusinessCentralController extends Controller
{
    public function test()
    {
        try {
            $data = [
                'customerId' => '2fa036bc-f05d-ee11-8def-000d3a4634e7',
                'shipToName' => 'Unimpack B.V.',
                'salesOrderLines' => [
                    [
                        'lineType' => 'Item',
                        'itemId' => 'bed9c4f6-0304-f011-9347-7c1e527686e3',
                        'quantity' => 10,
                        'unitPrice' => 20.0
                    ]
                ]
            ];

            $response = Http::businessCentral()->post('salesOrders', $data);

            if ($response->failed()) {
                return response()->json([
                    'status' => 'error',
                    'code' => $response->status(),
                    'body' => $response->body(),
                ]);
            }

            return response()->json([
                'status' => 'success',
                'data' => $response->json()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
} 