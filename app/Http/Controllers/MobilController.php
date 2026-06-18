<?php

namespace App\Http\Controllers;

use App\Models\Mobil;
use App\Models\Setting;
use Illuminate\Http\Request;

class MobilController extends Controller
{
    public function show(string $slug)
    {
        $mobil = Mobil::where('slug', $slug)->firstOrFail();

        // Increment views
        $mobil->increment('views_count');

        // Related units (same merek or kategori, exclude current)
        $related = Mobil::tersedia()
            ->where('id', '!=', $mobil->id)
            ->where(function ($q) use ($mobil) {
                $q->where('merek_id', $mobil->merek_id)
                  ->orWhere('kategori_id', $mobil->kategori_id);
            })
            ->take(4)
            ->get();

        $waNumber  = Setting::get('whatsapp_number');
        $waMessage = str_replace(
            ['[Nama Mobil]', '[Tahun]'],
            [$mobil->nama_mobil, $mobil->tahun],
            Setting::get('whatsapp_message')
        ) . "\n\nDetail unit: " . route('mobil.show', $slug);
        $waLink = "https://wa.me/{$waNumber}?text=" . urlencode($waMessage);

        return view('pages.detail', compact('mobil', 'related', 'waLink'));
    }
}
