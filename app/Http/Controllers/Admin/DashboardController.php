<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Mobil;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUnit       = Mobil::count();
        $unitTersedia    = Mobil::where('status', 'tersedia')->count();
        $unitTerjual     = Mobil::where('status', 'terjual')->count();
        $bookingPending  = Booking::where('status', 'pending')->count();
        $bookingBulanIni = Booking::whereMonth('created_at', now()->month)
                                  ->whereYear('created_at', now()->year)
                                  ->count();

        $unitTerpopuler = Mobil::orderByDesc('views_count')->take(5)->get();

        $bookingTerbaru = Booking::with('mobil')->latest()->take(5)->get();

        // Views per day for last 7 days (simplified — total views divided)
        $recentBookings = Booking::selectRaw('DATE(created_at) as tgl, COUNT(*) as total')
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('tgl')
            ->orderBy('tgl')
            ->pluck('total', 'tgl');

        return view('admin.dashboard', compact(
            'totalUnit', 'unitTersedia', 'unitTerjual',
            'bookingPending', 'bookingBulanIni',
            'unitTerpopuler', 'bookingTerbaru', 'recentBookings'
        ));
    }
}
