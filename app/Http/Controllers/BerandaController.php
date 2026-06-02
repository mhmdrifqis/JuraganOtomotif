<?php

namespace App\Http\Controllers;

use App\Models\Mobil;
use App\Models\Merek;
use App\Models\Kategori;
use App\Models\Banner;
use Illuminate\Http\Request;

class BerandaController extends Controller
{
    public function index()
    {
        $banners = Banner::where('is_active', true)->orderBy('urutan')->get();
        $unitUnggulan = Mobil::tersedia()->featured()->latest()->take(6)->get();
        $unitTerbaru  = Mobil::tersedia()->latest()->take(6)->get();
        $totalUnit    = Mobil::tersedia()->count();
        $totalMerek   = Mobil::tersedia()->distinct('merek_id')->count('merek_id');

        $merekPopuler = Merek::withCount(['mobils' => function($q) {
                $q->where('status', 'tersedia');
            }])
            ->orderByDesc('mobils_count')
            ->get();

        $kategoriList = Kategori::withCount(['mobils' => function($q) {
                $q->where('status', 'tersedia');
            }])
            ->orderByDesc('mobils_count')
            ->get();

        return view('pages.beranda', compact(
            'banners', 'unitUnggulan', 'unitTerbaru', 'totalUnit', 'totalMerek', 'merekPopuler', 'kategoriList'
        ));
    }
}
