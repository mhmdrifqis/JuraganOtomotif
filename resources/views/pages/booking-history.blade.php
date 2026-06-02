@extends('layouts.app')
@section('title', 'Riwayat Booking - Juragan Otomotif')

@section('content')
<div style="max-width:1280px; margin:0 auto; padding:2rem 1.25rem;">
    <h1 class="section-title" style="margin-bottom:0.5rem; display:flex; align-items:center; gap:0.5rem;"><x-lucide-calendar-check style="width:2rem;height:2rem;" /> Riwayat Booking Saya</h1>
    <p style="color:var(--text-muted); margin-bottom:2rem;">Daftar test drive yang telah Anda jadwalkan.</p>

    @if($bookings->isEmpty())
        <div style="background:#fff; border-radius:1rem; padding:4rem 2rem; text-align:center; box-shadow:0 10px 40px rgba(0,0,0,0.05); border:1px solid #f1f5f9;">
            <div style="display:inline-flex; align-items:center; justify-content:center; width:80px; height:80px; border-radius:50%; background:#f8fafc; color:#cbd5e1; margin-bottom:1.25rem;">
                <x-lucide-calendar-x style="width:2.5rem;height:2.5rem;" />
            </div>
            <h3 style="font-family:'Poppins',sans-serif; font-weight:700; font-size:1.25rem; color:var(--navy); margin-bottom:0.5rem;">Belum ada riwayat booking</h3>
            <p style="color:var(--text-muted); margin-bottom:1.5rem; max-width:400px; margin-left:auto; margin-right:auto;">Anda belum pernah melakukan pemesanan jadwal test drive dengan nomor WhatsApp Anda.</p>
            <a href="{{ route('katalog') }}" class="btn-primary" style="display:inline-flex; align-items:center; justify-content:center;">Lihat Katalog Mobil</a>
        </div>
    @else
        <div style="display:grid; gap:1.5rem;">
            @foreach($bookings as $booking)
            <div style="background:#fff; border-radius:1rem; padding:1.5rem; box-shadow:0 10px 40px rgba(0,0,0,0.05); border:1px solid #f1f5f9; display:flex; flex-direction:column; gap:1.25rem; position:relative; overflow:hidden;">
                <!-- Status Badge -->
                <div style="position:absolute; top:1.5rem; right:1.5rem;">
                    @php
                        $statusColors = [
                            'pending' => ['bg' => '#fef3c7', 'text' => '#d97706'],
                            'dikonfirmasi' => ['bg' => '#dbeafe', 'text' => '#2563eb'],
                            'selesai' => ['bg' => '#dcfce3', 'text' => '#16a34a'],
                            'dibatalkan' => ['bg' => '#fee2e2', 'text' => '#dc2626'],
                        ];
                        $color = $statusColors[$booking->status] ?? ['bg' => '#f1f5f9', 'text' => '#64748b'];
                    @endphp
                    <span style="background:{{ $color['bg'] }}; color:{{ $color['text'] }}; padding:0.25rem 0.75rem; border-radius:999px; font-size:0.75rem; font-weight:700; text-transform:uppercase; letter-spacing:0.05em;">{{ $booking->status }}</span>
                </div>

                <div style="display:flex; gap:1.5rem; align-items:flex-start;">
                    @if($booking->mobil && $booking->mobil->foto_utama)
                    <div style="width:120px; height:90px; border-radius:0.5rem; overflow:hidden; flex-shrink:0;">
                        <img src="{{ asset('storage/' . $booking->mobil->foto_utama) }}" alt="{{ $booking->mobil->nama_mobil }}" style="width:100%; height:100%; object-fit:cover;">
                    </div>
                    @else
                    <div style="width:120px; height:90px; border-radius:0.5rem; background:#f1f5f9; flex-shrink:0; display:flex; align-items:center; justify-content:center; color:#cbd5e1;">
                        <x-lucide-car style="width:2rem;height:2rem;" />
                    </div>
                    @endif

                    <div style="flex:1;">
                        <div style="font-size:0.8rem; color:var(--text-muted); margin-bottom:0.25rem;">ID Booking: #{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }} • {{ $booking->created_at->format('d M Y') }}</div>
                        <h3 style="font-family:'Poppins',sans-serif; font-weight:700; font-size:1.15rem; color:var(--navy); margin-bottom:0.75rem;">
                            {{ $booking->mobil ? $booking->mobil->nama_mobil . ' ' . $booking->mobil->tahun : 'Unit Dihapus' }}
                        </h3>
                        
                        <div style="display:flex; gap:1.5rem; flex-wrap:wrap; font-size:0.9rem; color:var(--text-muted);">
                            <div style="display:flex; align-items:center; gap:0.4rem;">
                                <x-lucide-calendar style="width:1.1rem;height:1.1rem; color:var(--orange);" />
                                {{ \Carbon\Carbon::parse($booking->tanggal_test_drive)->format('l, d F Y') }}
                            </div>
                            <div style="display:flex; align-items:center; gap:0.4rem;">
                                <x-lucide-clock style="width:1.1rem;height:1.1rem; color:var(--orange);" />
                                {{ \App\Models\Booking::$slotJam[$booking->jam_preferred] ?? $booking->jam_preferred }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
