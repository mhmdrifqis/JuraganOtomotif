<?php

namespace App\Http\Controllers;

use App\Models\Mobil;
use App\Models\Merek;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KatalogController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->only([
            'search', 'merek', 'kategori', 'transmisi', 'bahan_bakar',
            'kota', 'harga_min', 'harga_max', 'tahun_min', 'tahun_max', 'warna', 'sort',
        ]);

        $query = Mobil::filter($filters);

        // Sort
        match ($filters['sort'] ?? 'terbaru') {
            'harga_asc'   => $query->orderBy('harga'),
            'harga_desc'  => $query->orderByDesc('harga'),
            'km_asc'      => $query->orderBy('kilometer'),
            'tahun_desc'  => $query->orderByDesc('tahun'),
            default       => $query->latest(),
        };

        $mobils = $query->paginate(12)->withQueryString();

        // Filter options
        $mereks    = Merek::orderBy('nama_merek')->get();
        $kategoris = Kategori::orderBy('nama_kategori')->get();
        $kotas     = Mobil::distinct()->orderBy('kota')->pluck('kota');
        $warnas    = Mobil::distinct()->orderBy('warna')->pluck('warna');
        $hargaMin  = Mobil::min('harga') ?? 0;
        $hargaMax  = Mobil::max('harga') ?? 1000000000;
        $tahunMin  = Mobil::min('tahun') ?? 2010;
        $tahunMax  = Mobil::max('tahun') ?? date('Y');

        return view('pages.katalog', compact(
            'mobils', 'filters', 'mereks', 'kategoris', 'kotas', 'warnas',
            'hargaMin', 'hargaMax', 'tahunMin', 'tahunMax'
        ));
    }
}
