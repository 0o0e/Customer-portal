<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;

class ReportController extends Controller
{
    //
    public function create(){
        return view('addreport');
    }


    public function store(Request $request){
        $validated = $request->validate([
            'Customer_No' => 'required|string',
            'Link' => 'required|string' 
        ]);
        
        // Create the record without any validation
        $report = new Report();
        $report->Customer_No = $request->Customer_No;
        $report->Link = $request->Link;
        $report->save();
        
        return redirect()->back()->with('success', 'Report link added successfully!');
    }
}


