<?php

namespace App\Models;

use Illuminate\Support\Facades\Http;

class SalesQuotes
{
    // protected $baseUrl = 'salesQuotes';

    //
    public static function find($id)
    {
        // get quote from business central
        $response = Http::businessCentral()->get("salesQuotes($id)", [
            '$expand' => 'salesQuoteLines'
        ]);

        if (!$response->successful()) {
            return null;
        }


        return $response->json();
    }

    // send data to business central
    public static function create($data)
    {
        $response = Http::businessCentral()->post('salesQuotes', $data);
        return $response;
    }

    
    public static function all($filter = null)
    {
        $params = [];
        if ($filter) {
            $params['$filter'] = $filter;
        }
        $params['$expand'] = 'salesQuoteLines';

        $response = Http::businessCentral()->get('salesQuotes', $params);
        
        if (!$response->successful()) {
            return collect([]);
        }

        return collect($response->json()['value']);
    }
}
