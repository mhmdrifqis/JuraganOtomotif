@extends('layouts.app')
@section('title', 'Kontak — Juragan Otomotif')
@section('content')
<div style="max-width:800px; margin:0 auto; padding:3rem 1.25rem; text-align:center;">
    <h1 class="section-title" style="text-align:center; margin:0 auto 0.75rem;">Hubungi Kami</h1>
    <p style="color:var(--text-muted); margin-bottom:3rem;">Ada pertanyaan? Kami siap membantu Anda menemukan mobil impian.</p>

    @php
        $wa = \App\Models\Setting::get('whatsapp_number');
        $ig = \App\Models\Setting::get('instagram_url');
        $tk = \App\Models\Setting::get('tiktok_url');
        $alamat = \App\Models\Setting::get('alamat');
        $jam = \App\Models\Setting::get('jam_operasional');
    @endphp

    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px, 1fr)); gap:1.25rem; margin-bottom:2.5rem;">
        @if($wa)
        <a href="https://wa.me/{{ $wa }}" target="_blank" class="card-base" style="padding:2rem; text-decoration:none; transition:all 0.2s; display:block;" onmouseover="this.style.transform='translateY(-4px)'; this.style.borderColor='#25D366'" onmouseout="this.style.transform=''; this.style.borderColor='var(--border)'">
            <div style="font-size:3rem; margin-bottom:0.75rem; color:var(--orange);"><x-icon-wa style="width:3rem;height:3rem;" /></div>
            <div style="font-family:'Poppins',sans-serif; font-weight:700; color:var(--navy); margin-bottom:0.35rem;">WhatsApp</div>
            <div style="color:#25D366; font-weight:600; font-size:0.9rem;">+{{ $wa }}</div>
        </a>
        @endif
        @if($ig)
        <a href="{{ $ig }}" target="_blank" class="card-base" style="padding:2rem; text-decoration:none; transition:all 0.2s; display:block;" onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform=''">
            <div style="font-size:3rem; margin-bottom:0.75rem; color:var(--orange);"><x-lucide-camera style="width:3rem;height:3rem;" /></div>
            <div style="font-family:'Poppins',sans-serif; font-weight:700; color:var(--navy); margin-bottom:0.35rem;">Instagram</div>
            <div style="color:var(--text-muted); font-size:0.9rem;">@{{ Str::after($ig, 'instagram.com/') }}</div>
        </a>
        @endif
        @if($tk)
        <a href="{{ $tk }}" target="_blank" class="card-base" style="padding:2rem; text-decoration:none; transition:all 0.2s; display:block;" onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform=''">
            <div style="font-size:3rem; margin-bottom:0.75rem; color:var(--orange);"><x-lucide-music style="width:3rem;height:3rem;" /></div>
            <div style="font-family:'Poppins',sans-serif; font-weight:700; color:var(--navy); margin-bottom:0.35rem;">TikTok</div>
            <div style="color:var(--text-muted); font-size:0.9rem;">Juragan Otomotif</div>
        </a>
        @endif
        @if($alamat)
        <div class="card-base" style="padding:2rem;">
            <div style="font-size:3rem; margin-bottom:0.75rem; color:var(--orange);"><x-lucide-map-pin style="width:3rem;height:3rem;" /></div>
            <div style="font-family:'Poppins',sans-serif; font-weight:700; color:var(--navy); margin-bottom:0.35rem;">Lokasi</div>
            <div style="color:var(--text-muted); font-size:0.875rem; line-height:1.6;">{{ $alamat }}</div>
        </div>
        @endif
    </div>

    @if($jam)
    <div class="card-base" style="padding:1.5rem; display:inline-block;">
        <div style="font-size:2rem; margin-bottom:0.5rem; color:var(--orange);"><x-lucide-clock style="width:2rem;height:2rem;" /></div>
        <div style="font-family:'Poppins',sans-serif; font-weight:700; color:var(--navy); margin-bottom:0.25rem;">Jam Operasional</div>
        <div style="color:var(--text-muted);">{{ $jam }}</div>
    </div>
    @endif

    @if($wa)
    <div style="margin-top:2.5rem;">
        <a href="https://wa.me/{{ $wa }}" target="_blank" class="btn-wa" style="font-size:1.05rem; padding:0.95rem 3rem;">
            <span style="display:flex; align-items:center; gap:0.5rem;"><x-icon-wa style="width:1.25rem;height:1.25rem;" /> Chat Sekarang di WhatsApp</span>
        </a>
    </div>
    @endif
</div>
@endsection
