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
        
        // Filter by activity type
        if ($request->filled('activity_type')) {
            $query->where('activity_type', $request->activity_type);
        }
        
        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        // Search in description
        if ($request->filled('search')) {
            $query->where('description', 'like', '%' . $request->search . '%');
        }
        
        $activities = $query->paginate(20);
        
        // Get activity types for filter dropdown
        $activityTypes = UserActivity::where('user_id', $user->id)
            ->distinct()
            ->pluck('activity_type');
        
        return view('user-activities.index', compact('activities', 'activityTypes'));
    }

}
