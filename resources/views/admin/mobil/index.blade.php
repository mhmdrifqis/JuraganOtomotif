@extends('layouts.admin')

@section('title', 'Kelola Mobil Admin')
@section('page_title', 'Kelola Mobil')

@section('topbar_actions')
<a href="{{ route('admin.mobil.create') }}" class="btn-primary btn-sm">+ Tambah Unit</a>
@endsection

@section('content')

{{-- Filter --}}
<div class="card-base" style="padding:1.25rem; margin-bottom:1.5rem;">
    <form method="GET" action="{{ route('admin.mobil.index') }}" style="display:flex; gap:1rem; flex-wrap:wrap; align-items:flex-end;">
        <div style="flex:2; min-width:180px;">
            <label class="form-label" style="font-size:0.8rem;">Cari</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama atau merek..." class="form-control" style="font-size:0.875rem; padding:0.5rem 0.875rem;">
        </div>
        <div style="min-width:140px;">
            <label class="form-label" style="font-size:0.8rem;">Status</label>
            <select name="status" class="form-select" style="font-size:0.875rem; padding:0.5rem 0.875rem;">
                <option value="">Semua</option>
                @foreach(['tersedia','terjual','reservasi'] as $s)
                <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                @endforeach
                <option value="trashed" {{ request('status') === 'trashed' ? 'selected' : '' }}>Diarsipkan</option>
            </select>
        </div>
        <button type="submit" class="btn-navy btn-sm" style="display:flex; align-items:center; gap:0.25rem;"><x-lucide-search style="width:1rem;height:1rem;" /> Cari</button>
        @if(request()->hasAny(['search','status']))<a href="{{ route('admin.mobil.index') }}" class="btn-outline btn-sm">Reset</a>@endif
    </form>
</div>

{{-- Table --}}
<div class="card-base" style="overflow:hidden;">
    <div style="overflow-x:auto;">
        <table class="table-admin">
            <thead>
                <tr>
                    <th style="width:60px;">Foto</th>
                    <th>Unit</th>
                    <th>Harga</th>
                    <th>Tahun</th>
                    <th>KM</th>
                    <th>Status</th>
                    <th>Views</th>
                    <th>Unggulan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($mobils as $mobil)
                <tr style="{{ $mobil->trashed() ? 'opacity:0.6;' : '' }}">
                    <td>
                        @if($mobil->foto_utama)
                        <img src="{{ asset('storage/'.$mobil->foto_utama) }}" alt="{{ $mobil->nama_mobil }}"
                             style="width:60px; height:45px; object-fit:cover; border-radius:0.375rem;">
                        @else
                        <div style="width:60px; height:45px; background:var(--bg); border-radius:0.375rem; display:flex; align-items:center; justify-content:center; color:var(--navy);"><x-icon-car style="width:1.5rem;height:1.5rem;" /></div>
                        @endif
                    </td>
                    <td>
                        <div style="font-weight:600; color:var(--navy); font-size:0.9rem;">{{ $mobil->nama_mobil }}</div>
                        <div style="font-size:0.775rem; color:var(--text-muted);">{{ $mobil->merek->nama_merek ?? '-' }} · {{ $mobil->kategori->nama_kategori ?? '-' }} · {{ $mobil->kota }}</div>
                        @if($mobil->trashed())<span style="font-size:0.7rem; background:#fee2e2; color:#b91c1c; padding:0.1rem 0.5rem; border-radius:999px; font-weight:700;">ARSIP</span>@endif
                    </td>
                    <td style="font-weight:700; color:var(--navy); white-space:nowrap; font-size:0.9rem;">{{ $mobil->harga_formatted }}</td>
                    <td>{{ $mobil->tahun }}</td>
                    <td style="font-size:0.875rem; white-space:nowrap;">{{ number_format($mobil->kilometer, 0, ',', '.') }} km</td>
                    <td>
                        <span class="badge-status badge-{{ $mobil->status }}">{{ ucfirst($mobil->status) }}</span>
                    </td>
                    <td style="font-size:0.875rem; color:var(--text-muted);">{{ number_format($mobil->views_count) }}</td>
                    <td>
                        @if(!$mobil->trashed())
                        <form action="{{ route('admin.mobil.toggle-featured', $mobil) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" style="background:none; border:none; cursor:pointer; font-size:1.3rem;" title="{{ $mobil->is_featured ? 'Hapus dari unggulan' : 'Jadikan unggulan' }}">
                                <x-dynamic-component :component="$mobil->is_featured ? 'lucide-star' : 'lucide-star'" style="width:1.25rem;height:1.25rem; {{ $mobil->is_featured ? 'fill:currentColor;' : '' }}" />
                            </button>
                        </form>
                        @endif
                    </td>
                    <td>
                        <div style="display:flex; gap:0.4rem; flex-wrap:nowrap;">
                            @if(!$mobil->trashed())
                            <a href="{{ route('admin.mobil.edit', $mobil) }}" class="btn-navy btn-sm" style="white-space:nowrap; display:flex; align-items:center; gap:0.25rem;"><x-lucide-edit style="width:1rem;height:1rem;" /> Edit</a>
                            <form action="{{ route('admin.mobil.duplicate', $mobil) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn-sm btn-outline" style="white-space:nowrap; display:flex; align-items:center; justify-content:center;" title="Duplikasi"><x-lucide-copy style="width:1.25rem;height:1.25rem;" /></button>
                            </form>
                            <form action="{{ route('admin.mobil.destroy', $mobil) }}" method="POST" style="display:inline;" onsubmit="return confirm('Arsipkan unit ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-sm" style="background:#fee2e2; color:#b91c1c; border:none; border-radius:0.375rem; padding:0.4rem 0.6rem; cursor:pointer; display:flex; align-items:center; justify-content:center;" title="Hapus"><x-lucide-trash-2 style="width:1.25rem;height:1.25rem;" /></button>
                            </form>
                            @else
                            <form action="{{ route('admin.mobil.restore', $mobil->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn-sm" style="background:#dcfce7; color:#15803d; border:none; border-radius:0.375rem; padding:0.4rem 0.75rem; cursor:pointer; display:flex; align-items:center; gap:0.25rem;"><x-lucide-refresh-cw style="width:1rem;height:1rem;" /> Pulihkan</button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="9" style="text-align:center; padding:3rem; color:var(--text-muted);">
                    <p style="color:#cbd5e1; margin-bottom:0.5rem; display:flex; justify-content:center;"><x-icon-car style="width:3.5rem;height:3.5rem;" /></p>
                    <p>Belum ada unit. <a href="{{ route('admin.mobil.create') }}" style="color:var(--orange);">Tambah sekarang</a></p>
                </td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($mobils->hasPages())
    <div style="padding:1rem 1.5rem; border-top:1px solid var(--border);">
        <div class="pagination-wrap">
            @if($mobils->onFirstPage())<span class="disabled">‹</span>@else<a href="{{ $mobils->previousPageUrl() }}">‹</a>@endif
            @for($i=1; $i<=$mobils->lastPage(); $i++)
                @if($i === $mobils->currentPage())<span class="active">{{ $i }}</span>
                @elseif(abs($i - $mobils->currentPage()) <= 2)<a href="{{ $mobils->url($i) }}">{{ $i }}</a>
                @endif
            @endfor
            @if($mobils->hasMorePages())<a href="{{ $mobils->nextPageUrl() }}">›</a>@else<span class="disabled">›</span>@endif
        </div>
    </div>
    @endif
</div>

@endsection
