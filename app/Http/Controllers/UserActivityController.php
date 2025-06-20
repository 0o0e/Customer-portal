<?php

namespace App\Http\Controllers;

use App\Models\UserActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserActivityController extends Controller
{

    public function index(Request $request)
    {
        $user = Auth::user();
        
        $query = $user->activities()->orderBy('created_at', 'desc');
        
        // by activity type
        if ($request->filled('activity_type')) {
            $query->where('activity_type', $request->activity_type);
        }
        
        // date range validation
        $dateFrom = $request->filled('date_from') ? $request->date_from : null;
        $dateTo = $request->filled('date_to') ? $request->date_to : null;
        
        if ($dateFrom && $dateTo && $dateFrom > $dateTo) {
            return back()->withErrors(['date_range' => '"from date" cannot be after "to date".']);
        }
        
        // Apply date filters
        if ($dateFrom) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }
        
        if ($dateTo) {
            $query->whereDate('created_at', '<=', $dateTo);
        }
        
        // description
        if ($request->filled('search')) {
            $query->where('description', 'like', '%' . $request->search . '%');
        }
        
        $activities = $query->paginate(20);
        
        // getting the activity types
        $activityTypes = UserActivity::where('user_id', $user->id)
            ->distinct()
            ->pluck('activity_type');
        
        return view('user-activities.index', compact('activities', 'activityTypes'));
    }

}
