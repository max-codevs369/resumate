<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{User, Transaction, Resume, CvTemplate}; 
use Illuminate\Support\Facades\Auth;

class DashboardUserController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $totalMyCv = Resume::where('user_id', $user->id)->count(); 
        $totalMyDownloads = Resume::where('user_id', $user->id)->sum('downloads');
        $availableTemplates = CvTemplate::count();

        $completedCvs = Resume::where('user_id', $user->id)
            ->where('status', 'completed')
            ->with('template')
            ->latest()
            ->take(3)
            ->get();

        $draftCvs = Resume::where('user_id', $user->id)
            ->where('status', 'draft')
            ->with('template')
            ->latest()
            ->take(3)
            ->get();

        $popularTemplates = CvTemplate::latest()->take(4)->get();
        $lastTransaction = Transaction::where('user_id', $user->id)->latest()->first();

        return view('pages.dashboard.index', compact(
            'totalMyCv', 
            'totalMyDownloads', 
            'availableTemplates', 
            'completedCvs',
            'draftCvs',    
            'popularTemplates',
            'lastTransaction'
        ));
    }

    public function showProfile($id)
    {
        $user = User::findOrFail($id);
        return view('pages.dashboard.profile', compact('user'));
    }

    public function myResumes(Request $request)
    {
        $user = Auth::user();
        
        $status = $request->query('status', 'completed');

        $resumes = Resume::where('user_id', $user->id)
            ->where('status', $status)
            ->with('template')
            ->latest()
            ->paginate(9);

        $completedCount = Resume::where('user_id', $user->id)->where('status', 'completed')->count();
        $draftCount = Resume::where('user_id', $user->id)->where('status', 'draft')->count();

        return view('pages.dashboard.resumes', compact('resumes', 'status', 'completedCount', 'draftCount'));
    }
}