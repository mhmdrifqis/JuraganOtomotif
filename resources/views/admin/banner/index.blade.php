@extends('layouts.admin')
@section('title', 'Manajemen Banner')

@section('topbar_actions')
<a href="{{ route('admin.banner.create') }}" class="btn-primary" style="display:flex; align-items:center; gap:0.5rem;">
    <x-lucide-plus style="width:1.25rem;height:1.25rem;" /> Tambah Banner
</a>
@endsection

@section('content')
<div class="card" style="background:#fff; border-radius:var(--radius-lg); border:1px solid var(--border); overflow:hidden;">
    <div style="padding:1.5rem; border-bottom:1px solid var(--border);">
        <h2 style="font-family:'Poppins',sans-serif; font-size:1.25rem; font-weight:700; color:var(--navy); margin:0;">Daftar Banner</h2>
    </div>

    <div style="overflow-x:auto;">
        <table style="width:100%; border-collapse:collapse; text-align:left;">
            <thead>
                <tr style="background:#f8fafc; border-bottom:1px solid var(--border);">
                    <th style="padding:1rem 1.5rem; font-size:0.85rem; color:var(--text-muted); text-transform:uppercase; letter-spacing:0.05em; font-weight:600;">Urutan</th>
                    <th style="padding:1rem 1.5rem; font-size:0.85rem; color:var(--text-muted); text-transform:uppercase; letter-spacing:0.05em; font-weight:600;">Gambar</th>
                    <th style="padding:1rem 1.5rem; font-size:0.85rem; color:var(--text-muted); text-transform:uppercase; letter-spacing:0.05em; font-weight:600;">Title</th>
                    <th style="padding:1rem 1.5rem; font-size:0.85rem; color:var(--text-muted); text-transform:uppercase; letter-spacing:0.05em; font-weight:600;">Status</th>
                    <th style="padding:1rem 1.5rem; font-size:0.85rem; color:var(--text-muted); text-transform:uppercase; letter-spacing:0.05em; font-weight:600; text-align:right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($banners as $b)
                <tr style="border-bottom:1px solid var(--border); transition:all 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                    <td style="padding:1rem 1.5rem; font-weight:600; color:var(--navy);">#{{ $b->urutan }}</td>
                    <td style="padding:1rem 1.5rem;">
                        <img src="{{ asset('storage/' . $b->image_path) }}" alt="Banner" style="height:60px; width:120px; object-fit:cover; border-radius:0.5rem; border:1px solid var(--border);">
                    </td>
                    <td style="padding:1rem 1.5rem;">
                        <div style="font-weight:600; color:var(--navy);">{{ $b->title ?: '-' }}</div>
                        <div style="font-size:0.85rem; color:var(--text-muted);">{{ $b->subtitle ?: '-' }}</div>
                    </td>
                    <td style="padding:1rem 1.5rem;">
                        @if($b->is_active)
                        <span style="display:inline-flex; align-items:center; padding:0.25rem 0.75rem; border-radius:999px; font-size:0.75rem; font-weight:600; background:rgba(34,197,94,0.1); color:#16a34a;">Aktif</span>
                        @else
                        <span style="display:inline-flex; align-items:center; padding:0.25rem 0.75rem; border-radius:999px; font-size:0.75rem; font-weight:600; background:rgba(239,68,68,0.1); color:#dc2626;">Nonaktif</span>
                        @endif
                    </td>
                    <td style="padding:1rem 1.5rem; text-align:right;">
                        <div style="display:flex; justify-content:flex-end; gap:0.5rem;">
                            <a href="{{ route('admin.banner.edit', $b->id) }}" class="btn-outline" style="padding:0.5rem; border-radius:0.5rem; color:var(--navy);"><x-lucide-edit style="width:1.25rem;height:1.25rem;" /></a>
                            <form action="{{ route('admin.banner.destroy', $b->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus banner ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-outline" style="padding:0.5rem; border-radius:0.5rem; color:#dc2626; border-color:rgba(220,38,38,0.3);"><x-lucide-trash-2 style="width:1.25rem;height:1.25rem;" /></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="padding:3rem; text-align:center; color:var(--text-muted);">
                        <x-lucide-image style="width:3rem;height:3rem; margin:0 auto 1rem; color:#cbd5e1;" />
                        <p>Belum ada banner. <a href="{{ route('admin.banner.create') }}" style="color:var(--orange);">Tambah sekarang.</a></p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
