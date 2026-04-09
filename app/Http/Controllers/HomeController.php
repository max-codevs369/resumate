<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\{User, CvTemplate};

class HomeController extends Controller
{
    public function home()
    {
        if(Auth::user() && Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard.index');
        }

        $userCount = User::where('role', 'user')->count();
        $templateCount = CvTemplate::count();
        
        $avgRating = CvTemplate::where('rating_count', '>', 0)->avg('average_rating') ?? 0;
        
        $userSatisfaction = round($avgRating * 20);

        if ($userSatisfaction <= 0) {
            $userSatisfaction = 98; 
        }

        $popularTemplates = CvTemplate::where('is_active', true)
            ->orderByDesc('total_downloads')
            ->orderByDesc('created_at')
            ->take(3)
            ->get();

        return view('pages.home', compact(
            'userCount', 
            'templateCount', 
            'popularTemplates', 
            'userSatisfaction' 
        ));
    }
}