@extends('layouts.app')

@section('title', 'Katalog Mobil Bekas — Juragan Otomotif')
@section('meta_desc', 'Temukan mobil bekas terbaik dengan filter lengkap. Berbagai pilihan merek, harga, dan kategori tersedia.')

@section('content')
<div style="max-width:1280px; margin:0 auto; padding:2rem 1.25rem;">

    {{-- Header --}}
    <div style="margin-bottom:1.5rem;">
        <h1 class="section-title">Katalog Mobil Bekas</h1>
        <p style="color:var(--text-muted); margin-top:0.5rem;">
            Ditemukan <strong style="color:var(--navy);">{{ $mobils->total() }} unit</strong>
            @if(!empty(array_filter($filters)))<span> sesuai filter</span>@endif
        </p>
    </div>

    <div class="katalog-layout" style="display:grid; grid-template-columns:280px 1fr; gap:2rem; align-items:start;">

        {{-- FILTER PANEL --}}
        <aside class="filter-panel katalog-filter" style="padding:1.5rem; position:sticky; top:80px;">
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:1.25rem;">
                <h2 style="font-family:'Poppins',sans-serif; font-weight:700; font-size:1rem; color:var(--navy); margin:0; display:flex; align-items:center; gap:0.5rem;"><x-lucide-search style="width:1.25rem;height:1.25rem;" /> Filter</h2>
                @if(!empty(array_filter($filters)))
                <a href="{{ route('katalog') }}" style="font-size:0.8rem; color:var(--orange); text-decoration:none; font-weight:600;">Reset Semua</a>
                @endif
            </div>

            <form id="filter-form" method="GET" action="{{ route('katalog') }}">
                {{-- Search --}}
                <div style="margin-bottom:1.25rem;">
                    <p class="filter-section-title">Kata Kunci</p>
                    <input type="text" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Nama, merek, tipe..." class="form-control" style="font-size:0.875rem;">
                </div>

                <div class="divider"></div>

                {{-- Merek --}}
                <div style="margin-bottom:1.25rem;">
                    <p class="filter-section-title">Merek</p>
                    <div style="display:flex; flex-direction:column; gap:0.4rem; max-height:180px; overflow-y:auto;">
                        @foreach($mereks as $merek)
                        <label style="display:flex; align-items:center; gap:0.5rem; cursor:pointer; font-size:0.875rem;">
                            <input type="checkbox" name="merek[]" value="{{ $merek->id }}"
                                   {{ in_array($merek->id, (array)($filters['merek'] ?? [])) ? 'checked' : '' }}
                                   onchange="document.getElementById('filter-form').submit()"
                                   style="accent-color:var(--orange);">
                            {{ $merek->nama_merek }}
                        </label>
                        @endforeach
                    </div>
                </div>

                <div class="divider"></div>

                {{-- Kategori --}}
                <div style="margin-bottom:1.25rem;">
                    <p class="filter-section-title">Kategori</p>
                    <div style="display:flex; flex-direction:column; gap:0.4rem;">
                        @foreach($kategoris as $kat)
                        <label style="display:flex; align-items:center; gap:0.5rem; cursor:pointer; font-size:0.875rem;">
                            <input type="checkbox" name="kategori[]" value="{{ $kat->slug }}"
                                   {{ in_array($kat->slug, (array)($filters['kategori'] ?? [])) ? 'checked' : '' }}
                                   onchange="document.getElementById('filter-form').submit()"
                                   style="accent-color:var(--orange);">
                            {{ $kat->nama_kategori }}
                        </label>
                        @endforeach
                    </div>
                </div>

                <div class="divider"></div>

                {{-- Transmisi --}}
                <div style="margin-bottom:1.25rem;">
                    <p class="filter-section-title">Transmisi</p>
                    <div style="display:flex; flex-direction:column; gap:0.4rem;">
                        @foreach([''=>'Semua','manual'=>'Manual','matic'=>'Matic'] as $val => $lbl)
                        <label style="display:flex; align-items:center; gap:0.5rem; cursor:pointer; font-size:0.875rem;">
                            <input type="radio" name="transmisi" value="{{ $val }}"
                                   {{ ($filters['transmisi'] ?? '') === $val ? 'checked' : '' }}
                                   onchange="document.getElementById('filter-form').submit()"
                                   style="accent-color:var(--orange);">
                            {{ $lbl }}
                        </label>
                        @endforeach
                    </div>
                </div>

                <div class="divider"></div>

                {{-- Harga Range --}}
                <div style="margin-bottom:1.25rem;">
                    <p class="filter-section-title">Rentang Harga</p>
                    <div style="display:flex; gap:0.5rem; align-items:center;">
                        <input type="number" name="harga_min" value="{{ $filters['harga_min'] ?? '' }}" placeholder="Min" class="form-control" style="font-size:0.8rem; padding:0.5rem 0.75rem;">
                        <span style="color:var(--text-muted);">—</span>
                        <input type="number" name="harga_max" value="{{ $filters['harga_max'] ?? '' }}" placeholder="Max" class="form-control" style="font-size:0.8rem; padding:0.5rem 0.75rem;">
                    </div>
                    <button type="submit" class="btn-navy btn-sm" style="width:100%; justify-content:center; margin-top:0.5rem;">Terapkan</button>
                </div>

                <div class="divider"></div>

                {{-- Tahun Range --}}
                <div style="margin-bottom:1.25rem;">
                    <p class="filter-section-title">Tahun</p>
                    <div style="display:flex; gap:0.5rem; align-items:center;">
                        <input type="number" name="tahun_min" value="{{ $filters['tahun_min'] ?? '' }}" placeholder="{{ $tahunMin }}" class="form-control" style="font-size:0.8rem; padding:0.5rem 0.75rem;">
                        <span style="color:var(--text-muted);">—</span>
                        <input type="number" name="tahun_max" value="{{ $filters['tahun_max'] ?? '' }}" placeholder="{{ $tahunMax }}" class="form-control" style="font-size:0.8rem; padding:0.5rem 0.75rem;">
                    </div>
                    <button type="submit" class="btn-navy btn-sm" style="width:100%; justify-content:center; margin-top:0.5rem;">Terapkan</button>
                </div>

                <div class="divider"></div>

                {{-- Kota --}}
                <div style="margin-bottom:1.25rem;">
                    <p class="filter-section-title">Kota</p>
                    <select name="kota" class="form-select" style="font-size:0.875rem;" onchange="document.getElementById('filter-form').submit()">
                        <option value="">Semua Kota</option>
                        @foreach($kotas as $kota)
                        <option value="{{ $kota }}" {{ ($filters['kota'] ?? '') === $kota ? 'selected' : '' }}>{{ $kota }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="divider"></div>

                {{-- Bahan Bakar --}}
                <div>
                    <p class="filter-section-title">Bahan Bakar</p>
                    <div style="display:flex; flex-direction:column; gap:0.4rem;">
                        @foreach(['bensin'=>'Bensin','diesel'=>'Diesel','hybrid'=>'Hybrid','listrik'=>'Listrik'] as $val => $lbl)
                        <label style="display:flex; align-items:center; gap:0.5rem; cursor:pointer; font-size:0.875rem;">
                            <input type="checkbox" name="bahan_bakar[]" value="{{ $val }}"
                                   {{ in_array($val, (array)($filters['bahan_bakar'] ?? [])) ? 'checked' : '' }}
                                   onchange="document.getElementById('filter-form').submit()"
                                   style="accent-color:var(--orange);">
                            {{ $lbl }}
                        </label>
                        @endforeach
                    </div>
                </div>

            </form>
        </aside>

        {{-- HASIL LISTING --}}
        <div>
            {{-- Sort + View Toggle --}}
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:1.25rem; flex-wrap:wrap; gap:0.75rem;">
                <form method="GET" action="{{ route('katalog') }}" style="display:flex; align-items:center; gap:0.5rem;">
                    @foreach($filters as $k => $v)
                        @if($k !== 'sort')
                            @if(is_array($v))
                                @foreach($v as $vi)
                                <input type="hidden" name="{{ $k }}[]" value="{{ $vi }}">
                                @endforeach
                            @else
                            <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                            @endif
                        @endif
                    @endforeach
                    <span style="font-size:0.875rem; color:var(--text-muted);">Urutkan:</span>
                    <select name="sort" class="form-select" style="font-size:0.875rem; padding:0.4rem 0.75rem; width:auto;" onchange="this.form.submit()">
                        <option value="terbaru" {{ ($filters['sort'] ?? '') === 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                        <option value="harga_asc" {{ ($filters['sort'] ?? '') === 'harga_asc' ? 'selected' : '' }}>Harga Terendah</option>
                        <option value="harga_desc" {{ ($filters['sort'] ?? '') === 'harga_desc' ? 'selected' : '' }}>Harga Tertinggi</option>
                        <option value="km_asc" {{ ($filters['sort'] ?? '') === 'km_asc' ? 'selected' : '' }}>KM Terendah</option>
                        <option value="tahun_desc" {{ ($filters['sort'] ?? '') === 'tahun_desc' ? 'selected' : '' }}>Tahun Terbaru</option>
                    </select>
                </form>
            </div>

            {{-- Grid --}}
            @if($mobils->isNotEmpty())
            <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(260px, 1fr)); gap:1.25rem;">
                @foreach($mobils as $mobil)
                @include('components.card-mobil', ['mobil' => $mobil])
                @endforeach
            </div>

            {{-- Pagination --}}
            @if($mobils->hasPages())
            <div class="pagination-wrap" style="justify-content:center; margin-top:2rem;">
                {{-- Prev --}}
                @if($mobils->onFirstPage())
                <span class="disabled">‹</span>
                @else
                <a href="{{ $mobils->previousPageUrl() }}">‹</a>
                @endif

                {{-- Pages --}}
                @for($i = 1; $i <= $mobils->lastPage(); $i++)
                @if($i === $mobils->currentPage())
                <span class="active">{{ $i }}</span>
                @elseif(abs($i - $mobils->currentPage()) <= 2)
                <a href="{{ $mobils->url($i) }}">{{ $i }}</a>
                @endif
                @endfor

                {{-- Next --}}
                @if($mobils->hasMorePages())
                <a href="{{ $mobils->nextPageUrl() }}">›</a>
                @else
                <span class="disabled">›</span>
                @endif
            </div>
            @endif

            @else
            <div style="text-align:center; padding:4rem 2rem; background:#fff; border-radius:var(--radius-lg); border:2px dashed var(--border);">
                <p style="font-size:4rem; margin-bottom:1rem; color:#cbd5e1;"><x-lucide-search style="width:4rem;height:4rem;margin:0 auto;" /></p>
                <h3 style="font-family:'Poppins',sans-serif; color:var(--navy); margin-bottom:0.5rem;">Unit tidak ditemukan</h3>
                <p style="color:var(--text-muted); margin-bottom:1.5rem;">Coba ubah filter pencarian Anda</p>
                <a href="{{ route('katalog') }}" class="btn-primary">Reset Filter</a>
            </div>
            @endif
        </div>

    </div>
</div>

{{-- Compare Bar --}}
<div class="compare-bar" id="compare-bar">
    <div style="max-width:1280px; margin:0 auto; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:1rem;">
        <div>
            <span style="font-family:'Poppins',sans-serif; font-weight:600; display:flex; align-items:center; gap:0.5rem;"><x-lucide-git-compare-arrows style="width:1.25rem;height:1.25rem;" /> Perbandingan: </span>
            <span id="compare-names" style="font-size:0.9rem; opacity:0.85;"></span>
        </div>
        <div style="display:flex; gap:0.75rem;">
            <button onclick="clearBandingkan()" style="background:rgba(255,255,255,0.15); color:#fff; border:1px solid rgba(255,255,255,0.3); border-radius:0.5rem; padding:0.4rem 1rem; cursor:pointer; font-size:0.875rem;">Hapus</button>
            <button onclick="goBandingkan()" class="btn-primary btn-sm">Bandingkan Sekarang →</button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// Comparison logic (localStorage)
let compareList = JSON.parse(localStorage.getItem('compare') || '[]');

function tambahBandingkan(id, nama) {
    if (compareList.length >= 3) { alert('Maksimal 3 unit yang bisa dibandingkan.'); return; }
    if (compareList.find(i => i.id === id)) { alert('Unit sudah ada di daftar perbandingan.'); return; }
    compareList.push({ id, nama });
    localStorage.setItem('compare', JSON.stringify(compareList));
    updateCompareBar();
}

function clearBandingkan() {
    compareList = [];
    localStorage.setItem('compare', JSON.stringify(compareList));
    updateCompareBar();
}

function goBandingkan() {
    const ids = compareList.map(i => i.id).join(',');
    window.location.href = '{{ route("bandingkan") }}?ids=' + ids;
}

function updateCompareBar() {
    const bar = document.getElementById('compare-bar');
    const names = document.getElementById('compare-names');
    if (compareList.length > 0) {
        bar.classList.add('active');
        names.textContent = compareList.map(i => i.nama).join(' vs ');
    } else {
        bar.classList.remove('active');
    }
}

updateCompareBar();
</script>
@endpush
