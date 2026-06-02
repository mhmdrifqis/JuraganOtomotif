@props(['mobil'])

<div class="card-mobil" id="mobil-card-{{ $mobil->id }}">
    {{-- Foto --}}
    <a href="{{ route('mobil.show', $mobil->slug) }}" class="foto-wrapper" style="display:block; text-decoration:none;">
        @if($mobil->foto_utama)
            <img src="{{ asset('storage/' . $mobil->foto_utama) }}" alt="{{ $mobil->nama_mobil }}" loading="lazy">
        @else
            <div class="no-foto-placeholder"><x-icon-car style="width:3rem;height:3rem;" /></div>
        @endif
        {{-- Status badge --}}
        <div style="position:absolute; top:0.75rem; left:0.75rem;">
            <span class="badge-status badge-{{ $mobil->status }}" style="display:flex; align-items:center; gap:0.25rem;">
                @if($mobil->status === 'tersedia') <x-lucide-check style="width:1rem;height:1rem;" /> @elseif($mobil->status === 'terjual') <x-lucide-x style="width:1rem;height:1rem;" /> @else <x-lucide-clock style="width:1rem;height:1rem;" /> @endif
                {{ ucfirst($mobil->status) }}
            </span>
        </div>
        {{-- Featured badge --}}
        @if($mobil->is_featured)
        <div style="position:absolute; top:0.75rem; right:0.75rem;">
            <span style="background:var(--orange); color:#fff; font-size:0.7rem; font-weight:700; font-family:'Poppins',sans-serif; padding:0.2rem 0.6rem; border-radius:999px; display:flex; align-items:center; gap:0.25rem;"><x-lucide-star style="width:0.875rem;height:0.875rem;" /> Unggulan</span>
        </div>
        @endif
    </a>

    <div class="card-body">
        {{-- Merek & Kategori --}}
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:0.4rem;">
            <span style="font-size:0.775rem; font-weight:600; color:var(--orange); font-family:'Poppins',sans-serif; text-transform:uppercase; letter-spacing:0.05em;">{{ $mobil->merek->nama_merek }}</span>
            <span style="font-size:0.75rem; color:var(--text-muted); background:var(--bg); padding:0.15rem 0.6rem; border-radius:999px;">{{ $mobil->kategori->nama_kategori ?? '-' }}</span>
        </div>

        {{-- Nama --}}
        <h3 style="font-size:1rem; font-family:'Poppins',sans-serif; font-weight:700; color:var(--text); margin-bottom:0.5rem; line-height:1.3;">
            <a href="{{ route('mobil.show', $mobil->slug) }}" style="text-decoration:none; color:inherit; transition:color 0.2s;" onmouseover="this.style.color='var(--navy)'" onmouseout="this.style.color='inherit'">
                {{ $mobil->nama_mobil }}
            </a>
        </h3>

        {{-- Spesifikasi ringkas --}}
        <div style="display:flex; flex-wrap:wrap; gap:0.4rem; margin-bottom:0.875rem; font-size:0.8rem; color:var(--text-muted);">
            <span style="display:inline-flex; align-items:center; gap:0.25rem;"><x-lucide-calendar style="width:0.875rem;height:0.875rem;" /> {{ $mobil->tahun }}</span>
            <span>•</span>
            <span style="display:inline-flex; align-items:center; gap:0.25rem;"><x-lucide-settings style="width:0.875rem;height:0.875rem;" /> {{ ucfirst($mobil->transmisi) }}</span>
            <span>•</span>
            <span style="display:inline-flex; align-items:center; gap:0.25rem;"><x-lucide-fuel style="width:0.875rem;height:0.875rem;" /> {{ ucfirst($mobil->bahan_bakar) }}</span>
            <span>•</span>
            <span style="display:inline-flex; align-items:center; gap:0.25rem;"><x-lucide-gauge style="width:0.875rem;height:0.875rem;" /> {{ number_format($mobil->kilometer, 0, ',', '.') }} km</span>
        </div>

        {{-- Harga --}}
        <div style="margin-bottom:0.875rem;">
            <div style="font-family:'Poppins',sans-serif; font-size:1.2rem; font-weight:800; color:var(--navy);">
                {{ $mobil->harga_formatted }}
            </div>
        </div>

        {{-- Kota --}}
        <div style="font-size:0.8rem; color:var(--text-muted); margin-bottom:1rem; display:flex; align-items:center; gap:0.25rem;"><x-lucide-map-pin style="width:1rem;height:1rem;" /> {{ $mobil->kota }}</div>

        {{-- Actions --}}
        <div style="display:flex; gap:0.5rem;">
            <a href="{{ route('mobil.show', $mobil->slug) }}" class="btn-navy btn-sm" style="flex:1; justify-content:center;">Lihat Detail</a>
            @php
                $waNum = \App\Models\Setting::get('whatsapp_number');
                $waMsg = urlencode("Halo Juragan Otomotif, saya tertarik dengan {$mobil->nama_mobil} {$mobil->tahun}. Bisa info lebih lanjut?");
            @endphp
            <a href="https://wa.me/{{ $waNum }}?text={{ $waMsg }}" target="_blank"
               class="btn-sm" style="background:#25D366; color:#fff; border-radius:0.5rem; padding:0.4rem 0.75rem; display:flex; align-items:center; justify-content:center; text-decoration:none; transition:all 0.2s; border:none;"
               title="Hubungi via WhatsApp">
                <x-icon-wa style="width:1.25rem;height:1.25rem;" />
            </a>
            <button onclick="tambahBandingkan({{ $mobil->id }}, '{{ addslashes($mobil->nama_mobil) }}')"
                    class="btn-sm" style="background:var(--bg); color:var(--navy); border:1px solid var(--border); border-radius:0.5rem; padding:0.4rem 0.75rem; cursor:pointer; transition:all 0.2s; font-size:0.8rem; display:flex; align-items:center; justify-content:center;"
                    title="Tambah ke perbandingan">
                <x-lucide-git-compare-arrows style="width:1.25rem;height:1.25rem;" />
            </button>
        </div>
    </div>
</div>
