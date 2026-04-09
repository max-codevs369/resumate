<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{User, CvTemplate, Transaction};

class DashboardController extends Controller
{
    public function index()
    {
        $totalPengguna = User::where('role', 'user')->count();
        $totalTemplate = CvTemplate::where('is_active', true)->count();
        
        $totalRevenue = Transaction::where('status', 'approved')->sum('amount');
        
        $pendingVerifikasi = Transaction::where('status', 'pending')->count();

        $recentTransactions = Transaction::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalPengguna', 
            'totalTemplate', 
            'totalRevenue', 
            'pendingVerifikasi', 
            'recentTransactions'
        ));
    }
}