@extends('layouts.app')

@section('title', $mobil->nama_mobil . ' ' . $mobil->tahun . ' — Juragan Otomotif')
@section('meta_desc', 'Jual ' . $mobil->nama_mobil . ' tahun ' . $mobil->tahun . ', ' . $mobil->transmisi . ', ' . number_format($mobil->kilometer,0,',','.') . ' km. Harga ' . $mobil->harga_formatted . '. Lokasi: ' . $mobil->kota)

@section('content')
<div style="max-width:1280px; margin:0 auto; padding:2rem 1.25rem;">

    {{-- Breadcrumb --}}
    <nav style="font-size:0.825rem; color:var(--text-muted); margin-bottom:1.5rem; display:flex; align-items:center; gap:0.4rem; flex-wrap:wrap;">
        <a href="{{ route('beranda') }}" style="color:var(--text-muted); text-decoration:none;" onmouseover="this.style.color='var(--navy)'" onmouseout="this.style.color='var(--text-muted)'">Beranda</a>
        <span>›</span>
        <a href="{{ route('katalog') }}" style="color:var(--text-muted); text-decoration:none;" onmouseover="this.style.color='var(--navy)'" onmouseout="this.style.color='var(--text-muted)'">Katalog</a>
        <span>›</span>
        <span style="color:var(--navy); font-weight:500;">{{ $mobil->nama_mobil }}</span>
    </nav>

    <div class="detail-layout-grid">

        {{-- KIRI: Gallery + Deskripsi --}}
        <div>
            {{-- Gallery --}}
            @php $allFotos = $mobil->all_fotos; @endphp

            <div class="gallery-main card-base" x-data="gallery({{ json_encode($allFotos) }})" style="margin-bottom:1rem;">
                {{-- Main foto --}}
                <div style="position:relative; border-radius:var(--radius); overflow:hidden; aspect-ratio:16/10; background:#f1f5f9; cursor:pointer;" @click="openLightbox(current)">
                    <template x-if="fotos.length > 0">
                        <img :src="'/storage/' + fotos[current]" :alt="'{{ addslashes($mobil->nama_mobil) }}'"
                             style="width:100%; height:100%; object-fit:cover; transition:transform 0.3s;"
                             @mouseover="$el.style.transform='scale(1.02)'" @mouseout="$el.style.transform='scale(1)'">
                    </template>
                    <template x-if="fotos.length === 0">
                        <div style="display:flex; align-items:center; justify-content:center; height:100%; font-size:5rem; color:#cbd5e1;"><x-icon-car style="width:5rem;height:5rem;" /></div>
                    </template>
                    {{-- Nav arrows --}}
                    <template x-if="fotos.length > 1">
                        <button @click.stop="prev()" style="position:absolute; left:0.75rem; top:50%; transform:translateY(-50%); background:rgba(0,0,0,0.5); color:#fff; border:none; border-radius:50%; width:40px; height:40px; cursor:pointer; font-size:1.2rem; display:flex; align-items:center; justify-content:center;">‹</button>
                    </template>
                    <template x-if="fotos.length > 1">
                        <button @click.stop="next()" style="position:absolute; right:0.75rem; top:50%; transform:translateY(-50%); background:rgba(0,0,0,0.5); color:#fff; border:none; border-radius:50%; width:40px; height:40px; cursor:pointer; font-size:1.2rem; display:flex; align-items:center; justify-content:center;">›</button>
                    </template>
                    {{-- Counter --}}
                    <template x-if="fotos.length > 1">
                        <div style="position:absolute; bottom:0.75rem; right:0.75rem; background:rgba(0,0,0,0.6); color:#fff; font-size:0.8rem; padding:0.25rem 0.6rem; border-radius:999px;" x-text="(current+1) + ' / ' + fotos.length"></div>
                    </template>
                    <div style="position:absolute; bottom:0.75rem; left:0.75rem; font-size:0.75rem; color:#fff; opacity:0.8; display:flex; align-items:center; gap:0.25rem;"><x-lucide-search style="width:0.875rem;height:0.875rem;" /> Klik untuk perbesar</div>
                </div>

                {{-- Thumbnails --}}
                <template x-if="fotos.length > 1">
                    <div class="gallery-thumb" style="padding:0.75rem 0.5rem 0.5rem;">
                        <template x-for="(foto, i) in fotos" :key="i">
                            <img :src="'/storage/' + foto" @click="current = i" :class="{'active': current === i}" alt="Foto" loading="lazy">
                        </template>
                    </div>
                </template>

                {{-- Lightbox --}}
                <template x-if="lightboxOpen">
                    <div class="lightbox-overlay" @click="lightboxOpen = false" style="flex-direction:column; gap:1rem;">
                        <button @click="lightboxOpen = false" style="position:fixed; top:1rem; right:1.5rem; background:rgba(255,255,255,0.15); color:#fff; border:1px solid rgba(255,255,255,0.3); border-radius:50%; width:44px; height:44px; cursor:pointer; font-size:1.5rem; z-index:10000;">✕</button>
                        <img :src="'/storage/' + fotos[current]" @click.stop alt="Full" style="border-radius:0.5rem;">
                        <div style="display:flex; gap:1rem; align-items:center;">
                            <button @click.stop="prev()" style="background:rgba(255,255,255,0.2); color:#fff; border:none; border-radius:0.5rem; padding:0.5rem 1rem; cursor:pointer;">‹ Prev</button>
                            <span style="color:rgba(255,255,255,0.7); font-size:0.875rem;" x-text="(current+1) + ' / ' + fotos.length"></span>
                            <button @click.stop="next()" style="background:rgba(255,255,255,0.2); color:#fff; border:none; border-radius:0.5rem; padding:0.5rem 1rem; cursor:pointer;">Next ›</button>
                        </div>
                    </div>
                </template>
            </div>

            {{-- Deskripsi --}}
            @if($mobil->deskripsi)
            <div class="card-base" style="padding:1.5rem; margin-bottom:1.5rem;">
                <h3 style="font-family:'Poppins',sans-serif; font-weight:700; color:var(--navy); margin-bottom:1rem; display:flex; align-items:center; gap:0.5rem;"><x-lucide-clipboard-list style="width:1.5rem;height:1.5rem;" /> Deskripsi Unit</h3>
                <p style="line-height:1.8; color:var(--text);">{!! nl2br(e($mobil->deskripsi)) !!}</p>
            </div>
            @endif

            {{-- Spesifikasi Lengkap --}}
            <div class="card-base" style="padding:1.5rem; margin-bottom:1.5rem;">
                <h3 style="font-family:'Poppins',sans-serif; font-weight:700; color:var(--navy); margin-bottom:1.25rem; display:flex; align-items:center; gap:0.5rem;"><x-lucide-settings style="width:1.5rem;height:1.5rem;" /> Spesifikasi Lengkap</h3>
                <div class="spesifikasi-grid">
                    @php
                        $specs = [
                            'Merek'           => $mobil->merek->nama_merek,
                            'Kategori'        => $mobil->kategori->nama_kategori ?? '-',
                            'Nama Unit'       => $mobil->nama_mobil,
                            'Tahun'           => $mobil->tahun,
                            'Transmisi'       => ucfirst($mobil->transmisi),
                            'Bahan Bakar'     => ucfirst($mobil->bahan_bakar),
                            'Kapasitas Mesin' => number_format($mobil->kapasitas_mesin, 0, ',', '.') . ' cc',
                            'Kilometer'       => number_format($mobil->kilometer, 0, ',', '.') . ' km',
                            'Warna'           => $mobil->warna,
                            'Lokasi'          => $mobil->kota,
                        ];
                    @endphp
                    @foreach($specs as $label => $value)
                    <div style="padding:0.75rem; border-bottom:1px solid var(--border); {{ $loop->odd ? 'border-right:1px solid var(--border);' : '' }}">
                        <div style="font-size:0.775rem; color:var(--text-muted); font-weight:600; text-transform:uppercase; letter-spacing:0.04em; margin-bottom:0.2rem;">{{ $label }}</div>
                        <div style="font-weight:600; color:var(--text); font-family:'Poppins',sans-serif;">{{ $value }}</div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Share --}}
            <div class="card-base" style="padding:1.25rem;">
                <p style="font-size:0.875rem; font-weight:600; color:var(--text-muted); margin-bottom:0.75rem; font-family:'Poppins',sans-serif;">Bagikan Unit Ini:</p>
                <div style="display:flex; gap:0.75rem; flex-wrap:wrap;">
                    @php $shareUrl = urlencode(request()->url()); $shareTitle = urlencode($mobil->nama_mobil . ' ' . $mobil->tahun . ' - ' . $mobil->harga_formatted); @endphp
                    <a href="https://wa.me/?text={{ $shareTitle }}%20{{ $shareUrl }}" target="_blank" class="btn-wa btn-sm" style="display:flex; align-items:center; gap:0.25rem;"><x-icon-wa style="width:1rem;height:1rem;" /> WhatsApp</a>
                    <button onclick="navigator.clipboard.writeText(window.location.href); this.innerHTML='<x-icon name=\'check\' style=\'width:1rem;height:1rem;\' /> Copied!';" class="btn-sm btn-outline" style="display:flex; align-items:center; gap:0.25rem;"><x-lucide-link style="width:1rem;height:1rem;" /> Salin Link</button>
                </div>
            </div>
        </div>

        {{-- KANAN: Info + CTA --}}
        <div style="position:sticky; top:80px;">
            <div class="card-base" style="padding:1.75rem; margin-bottom:1.25rem;">
                {{-- Status --}}
                <div style="margin-bottom:1rem;">
                    <span class="badge-status badge-{{ $mobil->status }}" style="display:flex; align-items:center; gap:0.25rem;">
                        @if($mobil->status === 'tersedia') <x-lucide-check style="width:1rem;height:1rem;" /> @elseif($mobil->status === 'terjual') <x-lucide-x style="width:1rem;height:1rem;" /> @else <x-lucide-clock style="width:1rem;height:1rem;" /> @endif
                        {{ ucfirst($mobil->status) }}
                    </span>
                </div>

                {{-- Merek & Nama --}}
                <p style="font-size:0.8rem; color:var(--orange); font-weight:700; font-family:'Poppins',sans-serif; text-transform:uppercase; letter-spacing:0.05em; margin-bottom:0.4rem;">{{ $mobil->merek->nama_merek }} · {{ $mobil->kategori->nama_kategori ?? '-' }}</p>
                <h1 style="font-size:1.5rem; font-family:'Poppins',sans-serif; font-weight:800; color:var(--navy); margin-bottom:1rem; line-height:1.3;">{{ $mobil->nama_mobil }}</h1>

                {{-- Spek singkat --}}
                <div style="display:flex; flex-wrap:wrap; gap:0.5rem; margin-bottom:1.25rem;">
                    <span style="background:var(--bg); padding:0.3rem 0.75rem; border-radius:999px; font-size:0.8rem; color:var(--text-muted); border:1px solid var(--border); display:inline-flex; align-items:center; gap:0.25rem;"><x-lucide-calendar style="width:0.875rem;height:0.875rem;" /> {{ $mobil->tahun }}</span>
                    <span style="background:var(--bg); padding:0.3rem 0.75rem; border-radius:999px; font-size:0.8rem; color:var(--text-muted); border:1px solid var(--border); display:inline-flex; align-items:center; gap:0.25rem;"><x-lucide-settings style="width:0.875rem;height:0.875rem;" /> {{ ucfirst($mobil->transmisi) }}</span>
                    <span style="background:var(--bg); padding:0.3rem 0.75rem; border-radius:999px; font-size:0.8rem; color:var(--text-muted); border:1px solid var(--border); display:inline-flex; align-items:center; gap:0.25rem;"><x-lucide-fuel style="width:0.875rem;height:0.875rem;" /> {{ ucfirst($mobil->bahan_bakar) }}</span>
                    <span style="background:var(--bg); padding:0.3rem 0.75rem; border-radius:999px; font-size:0.8rem; color:var(--text-muted); border:1px solid var(--border); display:inline-flex; align-items:center; gap:0.25rem;"><x-lucide-gauge style="width:0.875rem;height:0.875rem;" /> {{ number_format($mobil->kilometer,0,',','.') }} km</span>
                    <span style="background:var(--bg); padding:0.3rem 0.75rem; border-radius:999px; font-size:0.8rem; color:var(--text-muted); border:1px solid var(--border); display:inline-flex; align-items:center; gap:0.25rem;"><x-lucide-map-pin style="width:0.875rem;height:0.875rem;" /> {{ $mobil->kota }}</span>
                </div>

                {{-- Harga --}}
                <div class="divider"></div>
                <div style="margin:1rem 0;">
                    <div style="font-size:0.8rem; color:var(--text-muted); margin-bottom:0.25rem;">Harga</div>
                    <div style="font-family:'Poppins',sans-serif; font-size:2rem; font-weight:900; color:var(--navy);">{{ $mobil->harga_formatted }}</div>
                </div>
                <div class="divider"></div>

                {{-- CTA --}}
                @if($mobil->status === 'tersedia')
                <div style="display:flex; flex-direction:column; gap:0.75rem; margin-top:1.25rem;">
                    <a href="{{ $waLink }}" target="_blank" class="btn-wa" style="width:100%; justify-content:center; font-size:1rem; padding:0.875rem; display:flex; align-items:center; gap:0.25rem;">
                        <x-icon-wa style="width:1.25rem;height:1.25rem;" /> Hubungi via WhatsApp
                    </a>
                    <a href="{{ route('booking.create', ['mobil_id' => $mobil->id]) }}" class="btn-primary" style="width:100%; justify-content:center; font-size:0.95rem; padding:0.75rem; display:flex; align-items:center; gap:0.25rem;">
                        <x-lucide-calendar style="width:1.25rem;height:1.25rem;" /> Booking Test Drive
                    </a>
                    <button onclick="tambahBandingkan({{ $mobil->id }}, '{{ addslashes($mobil->nama_mobil) }}')"
                            class="btn-outline" style="width:100%; justify-content:center; font-size:0.9rem; display:flex; align-items:center; gap:0.25rem;">
                        <x-lucide-git-compare-arrows style="width:1.25rem;height:1.25rem;" /> Tambah ke Perbandingan
                    </button>
                </div>
                @else
                <div style="background:var(--bg); border-radius:var(--radius); padding:1rem; text-align:center; margin-top:1rem;">
                    <p style="font-weight:600; color:var(--text-muted);">Unit ini sedang <strong>{{ $mobil->status }}</strong></p>
                    <a href="{{ route('katalog') }}" class="btn-navy btn-sm" style="margin-top:0.75rem; display:inline-flex;">Lihat Unit Lain</a>
                </div>
                @endif
            </div>

            {{-- Views --}}
            <p style="font-size:0.8rem; text-align:center; color:var(--text-muted); display:flex; align-items:center; justify-content:center; gap:0.25rem;"><x-lucide-eye style="width:1rem;height:1rem;" /> {{ number_format($mobil->views_count, 0, ',', '.') }} kali dilihat</p>
        </div>

    </div>

    {{-- Unit Terkait --}}
    @if($related->isNotEmpty())
    <div style="margin-top:4rem;">
        <h2 class="section-title" style="margin-bottom:1.5rem;">Unit Terkait Lainnya</h2>
        <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(250px, 1fr)); gap:1.25rem;">
            @foreach($related as $r)
            @include('components.card-mobil', ['mobil' => $r])
            @endforeach
        </div>
    </div>
    @endif

</div>

{{-- Compare Bar --}}
<div class="compare-bar" id="compare-bar">
    <div style="max-width:1280px; margin:0 auto; display:flex; align-items:center; justify-content:space-between;">
        <div style="display:flex; align-items:center; gap:0.5rem;"><x-lucide-git-compare-arrows style="width:1.25rem;height:1.25rem;" /> <span id="compare-names"></span></div>
        <div style="display:flex; gap:0.75rem;">
            <button onclick="clearBandingkan()" style="background:rgba(255,255,255,0.15); color:#fff; border:1px solid rgba(255,255,255,0.3); border-radius:0.5rem; padding:0.4rem 1rem; cursor:pointer;">Hapus</button>
            <button onclick="goBandingkan()" class="btn-primary btn-sm">Bandingkan →</button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// Alpine.js Gallery Component
function gallery(fotos) {
    return {
        fotos: fotos,
        current: 0,
        lightboxOpen: false,
        next() { this.current = (this.current + 1) % this.fotos.length; },
        prev() { this.current = (this.current - 1 + this.fotos.length) % this.fotos.length; },
        openLightbox(i) { if (this.fotos.length > 0) { this.current = i; this.lightboxOpen = true; } },
    };
}

// Compare
let compareList = JSON.parse(localStorage.getItem('compare') || '[]');
function tambahBandingkan(id, nama) {
    if (compareList.length >= 3) { showToast('Maksimal 3 unit.', 'error'); return; }
    if (compareList.find(i => i.id === id)) { showToast('Sudah ada di daftar.', 'error'); return; }
    compareList.push({ id, nama });
    localStorage.setItem('compare', JSON.stringify(compareList));
    updateCompareBar();
    showToast('Tersimpan! ' + nama + ' ditambahkan ke perbandingan.');
}
function clearBandingkan() { compareList = []; localStorage.setItem('compare', JSON.stringify(compareList)); updateCompareBar(); }
function goBandingkan() { window.location.href = '{{ route("bandingkan") }}?ids=' + compareList.map(i => i.id).join(','); }
function updateCompareBar() {
    const bar = document.getElementById('compare-bar');
    const names = document.getElementById('compare-names');
    if (compareList.length > 0) { bar.classList.add('active'); names.textContent = compareList.map(i => i.nama).join(' vs '); }
    else { bar.classList.remove('active'); }
}
updateCompareBar();
</script>
@endpush
