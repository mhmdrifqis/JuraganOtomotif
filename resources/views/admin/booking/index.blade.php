@extends('layouts.admin')

@section('title', 'Manajemen Booking')
@section('page_title', 'Manajemen Booking Test Drive')

@section('topbar_actions')
<div style="display:flex; gap:0.5rem;">
    <a href="{{ route('admin.booking.export', request()->query()) }}" class="btn-outline btn-sm" style="display:flex; align-items:center; gap:0.25rem;"><x-lucide-download style="width:1rem;height:1rem;" /> Export Excel</a>
    <a href="{{ route('admin.booking.create') }}" class="btn-primary btn-sm" style="display:flex; align-items:center; gap:0.25rem;"><x-lucide-plus style="width:1rem;height:1rem;" /> Tambah Booking</a>
</div>
@endsection

@section('content')

{{-- Filter --}}
<div class="card-base" style="padding:1.25rem; margin-bottom:1.5rem;">
    <form method="GET" action="{{ route('admin.booking.index') }}" style="display:flex; gap:1rem; flex-wrap:wrap; align-items:flex-end;">
        <div style="min-width:140px;">
            <label class="form-label" style="font-size:0.8rem;">Status</label>
            <select name="status" class="form-select" style="font-size:0.875rem; padding:0.5rem 0.875rem;" onchange="this.form.submit()">
                <option value="">Semua Status</option>
                @foreach($statusList as $val => $lbl)
                <option value="{{ $val }}" {{ request('status') === $val ? 'selected' : '' }}>{{ $lbl }}</option>
                @endforeach
            </select>
        </div>
        <div style="min-width:140px;">
            <label class="form-label" style="font-size:0.8rem;">Tanggal Dari</label>
            <input type="date" name="tanggal_dari" value="{{ request('tanggal_dari') }}" class="form-control" style="font-size:0.875rem; padding:0.5rem 0.875rem;">
        </div>
        <div style="min-width:140px;">
            <label class="form-label" style="font-size:0.8rem;">Tanggal Sampai</label>
            <input type="date" name="tanggal_sampai" value="{{ request('tanggal_sampai') }}" class="form-control" style="font-size:0.875rem; padding:0.5rem 0.875rem;">
        </div>
        <div style="flex:1; min-width:150px;">
            <label class="form-label" style="font-size:0.8rem;">Cari Pembeli</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama atau nomor HP..." class="form-control" style="font-size:0.875rem; padding:0.5rem 0.875rem;">
        </div>
        <button type="submit" class="btn-navy btn-sm" style="display:flex; align-items:center; gap:0.25rem;"><x-lucide-filter style="width:1rem;height:1rem;" /> Filter</button>
        @if(request()->hasAny(['status','tanggal_dari','tanggal_sampai','search']))<a href="{{ route('admin.booking.index') }}" class="btn-outline btn-sm">Reset</a>@endif
    </form>
</div>

{{-- Table --}}
<div class="card-base" style="overflow:hidden;">
    <div style="overflow-x:auto;">
        <table class="table-admin">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Pembeli</th>
                    <th>Unit</th>
                    <th>Tanggal</th>
                    <th>Jam</th>
                    <th>Status</th>
                    <th>Catatan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $booking)
                @php
                    $colors = ['pending'=>'#f59e0b','dikonfirmasi'=>'#3b82f6','selesai'=>'#22c55e','dibatalkan'=>'#ef4444'];
                    $c = $colors[$booking->status] ?? '#6b7280';
                @endphp
                <tr>
                    <td style="font-size:0.8rem; color:var(--text-muted);">#{{ $booking->id }}</td>
                    <td>
                        <div style="font-weight:600; font-size:0.9rem; color:var(--navy);">{{ $booking->nama_pembeli }}</div>
                        <a href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $booking->no_hp)) }}" target="_blank" style="font-size:0.775rem; color:#25D366; text-decoration:none; display:flex; align-items:center; gap:0.25rem;"><x-lucide-smartphone style="width:1rem;height:1rem;" /> {{ $booking->no_hp }}</a>
                    </td>
                    <td style="font-size:0.875rem;">
                        <a href="{{ route('mobil.show', $booking->mobil->slug ?? '') }}" target="_blank" style="color:var(--navy); text-decoration:none; font-weight:600;">{{ $booking->mobil->nama_mobil ?? '-' }}</a>
                        <div style="font-size:0.775rem; color:var(--text-muted);">{{ $booking->mobil->tahun ?? '' }}</div>
                    </td>
                    <td style="font-size:0.875rem; white-space:nowrap;">{{ $booking->tanggal_test_drive->format('d/m/Y') }}</td>
                    <td style="font-size:0.875rem; white-space:nowrap;">{{ \App\Models\Booking::$slotJam[$booking->jam_preferred] ?? $booking->jam_preferred }}</td>
                    <td>
                        <span style="display:inline-flex; align-items:center; padding:0.25rem 0.75rem; border-radius:999px; font-size:0.75rem; font-weight:700; background:{{ $c }}20; color:{{ $c }};">
                            {{ \App\Models\Booking::$statusLabel[$booking->status] ?? $booking->status }}
                        </span>
                    </td>
                    <td style="font-size:0.8rem; color:var(--text-muted); max-width:150px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;" title="{{ $booking->catatan }}">
                        {{ $booking->catatan ?: '-' }}
                    </td>
                    <td>
                        {{-- Update Status Modal Trigger --}}
                        <div style="display:flex; gap:0.4rem; align-items:center;">
                            <button onclick="toggleUpdateForm({{ $booking->id }})"
                                    class="btn-navy btn-sm" style="display:flex; align-items:center; gap:0.25rem;"><x-lucide-edit style="width:1rem;height:1rem;" /> Update</button>
                            <a href="{{ $booking->wa_link_pembeli }}" target="_blank"
                               class="btn-sm" style="background:#25D366; color:#fff; border-radius:0.375rem; padding:0.4rem 0.6rem; text-decoration:none; display:flex; align-items:center; justify-content:center;"><x-icon-wa style="width:1rem;height:1rem;" /></a>
                        </div>

                        {{-- Inline Update Form --}}
                        <div id="update-form-{{ $booking->id }}" style="display:none; margin-top:0.75rem; padding:1rem; background:var(--bg); border-radius:0.5rem; border:1px solid var(--border); min-width:240px;">
                            <form action="{{ route('admin.booking.update', $booking) }}" method="POST">
                                @csrf @method('PATCH')
                                <div style="margin-bottom:0.75rem;">
                                    <label class="form-label" style="font-size:0.8rem;">Status</label>
                                    <select name="status" class="form-select" style="font-size:0.875rem;">
                                        @foreach($statusList as $val => $lbl)
                                        <option value="{{ $val }}" {{ $booking->status === $val ? 'selected' : '' }}>{{ $lbl }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div style="margin-bottom:0.75rem;">
                                    <label class="form-label" style="font-size:0.8rem;">Catatan Admin</label>
                                    <textarea name="catatan_admin" class="form-control" rows="2" style="font-size:0.875rem;">{{ $booking->catatan_admin }}</textarea>
                                </div>
                                <div style="display:flex; gap:0.5rem;">
                                    <button type="submit" class="btn-primary btn-sm">Simpan</button>
                                    <button type="button" onclick="toggleUpdateForm({{ $booking->id }})" class="btn-outline btn-sm">Batal</button>
                                </div>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" style="text-align:center; padding:3rem; color:var(--text-muted);">
                    <p style="color:#cbd5e1; margin-bottom:0.5rem; display:flex; justify-content:center;"><x-lucide-calendar style="width:2.5rem;height:2.5rem;" /></p>
                    <p>Belum ada booking masuk.</p>
                </td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($bookings->hasPages())
    <div style="padding:1rem 1.5rem; border-top:1px solid var(--border);">
        <div class="pagination-wrap">
            @if($bookings->onFirstPage())<span class="disabled">‹</span>@else<a href="{{ $bookings->previousPageUrl() }}">‹</a>@endif
            @for($i=1; $i<=$bookings->lastPage(); $i++)
                @if($i === $bookings->currentPage())<span class="active">{{ $i }}</span>
                @elseif(abs($i - $bookings->currentPage()) <= 2)<a href="{{ $bookings->url($i) }}">{{ $i }}</a>
                @endif
            @endfor
            @if($bookings->hasMorePages())<a href="{{ $bookings->nextPageUrl() }}">›</a>@else<span class="disabled">›</span>@endif
        </div>
    </div>
    @endif
</div>

@endsection

@push('scripts')
<script>
function toggleUpdateForm(id) {
    const el = document.getElementById('update-form-' + id);
    el.style.display = el.style.display === 'none' ? 'block' : 'none';
}
</script>
@endpush
