<?php

namespace App\Http\Controllers;

use App\Models\Mobil;
use Illuminate\Http\Request;

class BandingkanController extends Controller
{
    public function index(Request $request)
    {
        $ids   = array_filter(explode(',', $request->query('ids', '')));
        $ids   = array_slice($ids, 0, 3); // max 3
        $mobils = count($ids) ? Mobil::whereIn('id', $ids)->get() : collect();

        $fields = [
            'Harga'            => fn($m) => $m->harga_formatted . ($m->bisa_nego ? ' (Nego)' : ''),
            'Tahun'            => fn($m) => $m->tahun,
            'Kilometer'        => fn($m) => number_format($m->kilometer, 0, ',', '.') . ' km',
            'Transmisi'        => fn($m) => ucfirst($m->transmisi),
            'Bahan Bakar'      => fn($m) => ucfirst($m->bahan_bakar),
            'Kapasitas Mesin'  => fn($m) => number_format($m->kapasitas_mesin, 0, ',', '.') . ' cc',
            'Kategori'         => fn($m) => $m->kategori,
            'Warna'            => fn($m) => $m->warna,
            'Kota'             => fn($m) => $m->kota,
            'Status'           => fn($m) => ucfirst($m->status),
        ];

        return view('pages.bandingkan', compact('mobils', 'fields'));
    }
}
