@extends('layouts.app')
@section('title', 'Tentang Kami — Juragan Otomotif')
@section('content')
<div style="max-width:960px; margin:0 auto; padding:3rem 1.25rem;">
    <div style="text-align:center; margin-bottom:3rem;">
        <h1 class="section-title" style="text-align:center; margin:0 auto 0.75rem;">Tentang Juragan Otomotif</h1>
        <p style="color:var(--text-muted); max-width:600px; margin:0 auto; font-size:1.05rem;">Platform jual beli mobil bekas terpercaya yang mengutamakan kepercayaan, transparansi, dan kemudahan bagi setiap pembeli.</p>
    </div>

    <div style="display:grid; grid-template-columns:1fr 1fr; gap:2rem; margin-bottom:3rem;">
        @foreach([
            ['eye','Visi Kami','Menjadi platform jual beli mobil bekas paling terpercaya dan mudah diakses di Indonesia.'],
            ['check','Misi Kami','Menghubungkan penjual dan pembeli dengan informasi yang transparan, lengkap, dan dapat dipercaya.'],
            ['shield-check','Nilai Kami','Kejujuran, transparansi, dan kepuasan pelanggan adalah prioritas utama kami dalam setiap transaksi.'],
            ['camera','Standar Kualitas','Setiap unit difoto dengan standar tinggi, minimal 5 foto, untuk memberikan gambaran yang jelas.'],
        ] as [$icon, $judul, $desc])
        <div class="card-base" style="padding:1.75rem;">
            <div style="font-size:2.5rem; margin-bottom:0.75rem; color:var(--orange);"><x-dynamic-component :component="'lucide-' . $icon" style="width:2.5rem;height:2.5rem;" /></div>
            <h3 style="font-family:'Poppins',sans-serif; font-weight:700; color:var(--navy); margin-bottom:0.5rem;">{{ $judul }}</h3>
            <p style="color:var(--text-muted); font-size:0.9rem; line-height:1.7;">{{ $desc }}</p>
        </div>
        @endforeach
    </div>

    {{-- Info Kontak --}}
    @php $alamat = \App\Models\Setting::get('alamat'); $jam = \App\Models\Setting::get('jam_operasional'); $wa = \App\Models\Setting::get('whatsapp_number'); @endphp
    <div class="card-base" style="padding:2rem; text-align:center;">
        <h2 style="font-family:'Poppins',sans-serif; font-weight:700; color:var(--navy); margin-bottom:1.5rem;">Informasi Showroom</h2>
        <div style="display:flex; justify-content:center; gap:3rem; flex-wrap:wrap;">
            @if($alamat)<div><div style="margin-bottom:0.5rem; color:var(--orange);"><x-lucide-map-pin style="width:2rem;height:2rem;margin:0 auto;" /></div><div style="font-weight:600; color:var(--navy);">Lokasi</div><div style="color:var(--text-muted); font-size:0.9rem; margin-top:0.25rem;">{{ $alamat }}</div></div>@endif
            @if($jam)<div><div style="margin-bottom:0.5rem; color:var(--orange);"><x-lucide-clock style="width:2rem;height:2rem;margin:0 auto;" /></div><div style="font-weight:600; color:var(--navy);">Jam Operasional</div><div style="color:var(--text-muted); font-size:0.9rem; margin-top:0.25rem;">{{ $jam }}</div></div>@endif
            @if($wa)<div><div style="margin-bottom:0.5rem; color:var(--orange);"><x-icon-wa style="width:2rem;height:2rem;margin:0 auto;" /></div><div style="font-weight:600; color:var(--navy);">WhatsApp</div><div style="color:var(--text-muted); font-size:0.9rem; margin-top:0.25rem;"><a href="https://wa.me/{{ $wa }}" target="_blank" style="color:var(--orange); text-decoration:none;">+{{ $wa }}</a></div></div>@endif
        </div>
    </div>
</div>
@endsection
