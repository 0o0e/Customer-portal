<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use Illuminate\Support\Facades\Auth;

class ReportViewController extends Controller
{
    //

    public function index(Request $request)
    {
        $user = Auth::user();
        
        if ($user->is_admin) {
            $reports = Report::all();
        } else if ($user->is_admin == false) {
            $reports = Report::where('Customer_No', $user->No)->get();
        }
        
        return view('reports', compact('reports'));
    }

    public function show($id)
    {
        $user = Auth::user();
        $report = Report::findOrFail($id);
        
        // Check if user has permission to view this report
        if (!$user->is_admin && $report->Customer_No != $user->No) {
            abort(403, 'Unauthorized access');
        }
        
        return view('report-single', compact('report'));
    }
}
