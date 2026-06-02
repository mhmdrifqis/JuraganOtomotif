@extends('layouts.admin')

@section('page_title', 'Dashboard')
@section('title', 'Dashboard Admin')

@section('content')

{{-- Stats Grid --}}
<div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px, 1fr)); gap:1.25rem; margin-bottom:2rem;">
    @foreach([
        ['box', 'Total Unit', $totalUnit, 'Semua listing', '#3b82f6'],
        ['check-circle-2', 'Unit Tersedia', $unitTersedia, 'Siap dibeli', '#22c55e'],
        ['check-square', 'Unit Terjual', $unitTerjual, 'Bulan ini', '#ef4444'],
        ['clock', 'Booking Pending', $bookingPending, 'Perlu konfirmasi', '#f59e0b'],
        ['calendar', 'Booking Bulan Ini', $bookingBulanIni, now()->format('F Y'), '#8b5cf6'],
    ] as [$icon, $label, $value, $sub, $color])
    <div class="admin-stat">
        <div style="display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:0.75rem;">
            <div style="font-size:1.75rem; color:{{ $color }};"><x-dynamic-component :component="'lucide-' . $icon" style="width:2rem;height:2rem;" /></div>
            <div style="width:8px; height:8px; border-radius:50%; background:{{ $color }}; margin-top:0.35rem;"></div>
        </div>
        <div class="admin-stat-number" style="color:{{ $color }};">{{ number_format($value) }}</div>
        <div style="font-family:'Poppins',sans-serif; font-weight:600; color:var(--navy); font-size:0.9rem; margin-top:0.25rem;">{{ $label }}</div>
        <div style="font-size:0.775rem; color:var(--text-muted); margin-top:0.15rem;">{{ $sub }}</div>
    </div>
    @endforeach
</div>

<div class="admin-grid-2-col">

    {{-- Unit Terpopuler --}}
    <div class="card-base" style="padding:1.5rem;">
        <h3 style="font-family:'Poppins',sans-serif; font-weight:700; color:var(--navy); margin-bottom:1.25rem; font-size:1rem; display:flex; align-items:center; gap:0.5rem;">
            <x-lucide-trophy style="width:1.25rem;height:1.25rem;color:var(--orange);" /> Unit Paling Banyak Dilihat
        </h3>
        @if($unitTerpopuler->isNotEmpty())
        <div style="display:flex; flex-direction:column; gap:0.75rem;">
            @foreach($unitTerpopuler as $idx => $u)
            <div style="display:flex; align-items:center; gap:1rem; padding:0.625rem 0; {{ !$loop->last ? 'border-bottom:1px solid var(--border);' : '' }}">
                <div style="width:32px; height:32px; border-radius:50%; background:{{ ['var(--orange)','#f59e0b','#6b7280','#6b7280','#6b7280'][$idx] ?? 'var(--bg)' }}; color:#fff; display:flex; align-items:center; justify-content:center; font-family:'Poppins',sans-serif; font-weight:800; font-size:0.85rem; flex-shrink:0;">{{ $idx+1 }}</div>
                <div style="flex:1; min-width:0;">
                    <a href="{{ route('mobil.show', $u->slug) }}" target="_blank" style="font-weight:600; color:var(--navy); text-decoration:none; font-size:0.9rem; display:block; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">{{ $u->nama_mobil }} {{ $u->tahun }}</a>
                    <div style="font-size:0.775rem; color:var(--text-muted);">{{ $u->kota }}</div>
                </div>
                <div style="text-align:right; flex-shrink:0;">
                    <div style="font-family:'Poppins',sans-serif; font-weight:700; color:var(--navy); font-size:0.925rem;">{{ number_format($u->views_count) }}</div>
                    <div style="font-size:0.75rem; color:var(--text-muted);">views</div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <p style="color:var(--text-muted); text-align:center; padding:2rem 0;">Belum ada data.</p>
        @endif
    </div>

    {{-- Booking Terbaru --}}
    <div class="card-base" style="padding:1.5rem;">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:1.25rem;">
            <h3 style="font-family:'Poppins',sans-serif; font-weight:700; color:var(--navy); font-size:1rem; margin:0; display:flex; align-items:center; gap:0.5rem;"><x-lucide-calendar-days style="width:1.25rem;height:1.25rem;" /> Booking Terbaru</h3>
            <a href="{{ route('admin.booking.index') }}" style="font-size:0.8rem; color:var(--orange); text-decoration:none; font-weight:600;">Lihat Semua →</a>
        </div>
        @if($bookingTerbaru->isNotEmpty())
        <div style="display:flex; flex-direction:column; gap:0.75rem;">
            @foreach($bookingTerbaru as $b)
            @php
                $colors = ['pending'=>'#f59e0b','dikonfirmasi'=>'#3b82f6','selesai'=>'#22c55e','dibatalkan'=>'#ef4444'];
                $c = $colors[$b->status] ?? '#6b7280';
            @endphp
            <div style="padding:0.75rem; background:var(--bg); border-radius:0.5rem; border-left:3px solid {{ $c }};">
                <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                    <div>
                        <div style="font-weight:600; font-size:0.875rem; color:var(--navy);">{{ $b->nama_pembeli }}</div>
                        <div style="font-size:0.775rem; color:var(--text-muted);">{{ $b->mobil->nama_mobil ?? '-' }} · {{ $b->tanggal_test_drive->format('d/m/Y') }}</div>
                    </div>
                    <span style="font-size:0.72rem; background:{{ $c }}20; color:{{ $c }}; padding:0.15rem 0.6rem; border-radius:999px; font-weight:700; white-space:nowrap;">{{ \App\Models\Booking::$statusLabel[$b->status] ?? $b->status }}</span>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <p style="color:var(--text-muted); text-align:center; padding:2rem 0;">Belum ada booking.</p>
        @endif
    </div>

</div>

{{-- Quick Actions --}}
<div style="display:flex; gap:1rem; margin-top:1.5rem; flex-wrap:wrap;">
    <a href="{{ route('admin.mobil.create') }}" class="btn-primary" style="display:flex; align-items:center; gap:0.25rem;"><x-lucide-plus style="width:1.25rem;height:1.25rem;" /> Tambah Unit Baru</a>
    <a href="{{ route('admin.booking.index', ['status' => 'pending']) }}" class="btn-navy" style="display:flex; align-items:center; gap:0.25rem;"><x-lucide-clock style="width:1.25rem;height:1.25rem;" /> Booking Pending ({{ $bookingPending }})</a>
    <a href="{{ route('admin.settings') }}" class="btn-outline" style="display:flex; align-items:center; gap:0.25rem;"><x-lucide-settings style="width:1.25rem;height:1.25rem;" /> Pengaturan</a>
</div>

@endsection
