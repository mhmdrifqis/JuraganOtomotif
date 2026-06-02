@extends('layouts.app')
@section('title', 'Booking Berhasil — Juragan Otomotif')

@section('content')
<div style="max-width:640px; margin:0 auto; padding:4rem 1.25rem; text-align:center;">
    <div class="card-base" style="padding:3rem 2rem;">
        <div style="font-size:5rem; margin-bottom:1rem; color:#15803d; animation:fadeInUp 0.5s ease-out; display:flex; justify-content:center;"><x-lucide-check-circle-2 style="width:5rem;height:5rem;" /></div>
        <h1 style="font-family:'Poppins',sans-serif; font-weight:800; color:var(--navy); font-size:1.75rem; margin-bottom:0.5rem;">
            Booking Terkirim!
        </h1>
        <p style="color:var(--text-muted); margin-bottom:2rem;">
            Terima kasih <strong>{{ $booking->nama_pembeli }}</strong>! Permintaan test drive Anda telah kami terima.
        </p>

        <div style="background:var(--bg); border-radius:var(--radius); padding:1.5rem; text-align:left; margin-bottom:2rem;">
            <h3 style="font-family:'Poppins',sans-serif; font-weight:700; color:var(--navy); font-size:0.95rem; margin-bottom:1rem;">Detail Booking #{{ $booking->id }}</h3>
            <div style="display:flex; flex-direction:column; gap:0.65rem;">
                @foreach([
                    ['Unit', $booking->mobil->nama_mobil . ' ' . $booking->mobil->tahun],
                    ['Tanggal', $booking->tanggal_test_drive->format('d/m/Y')],
                    ['Jam', \App\Models\Booking::$slotJam[$booking->jam_preferred] ?? $booking->jam_preferred],
                    ['Nomor HP', $booking->no_hp],
                    ['Status', 'Menunggu Konfirmasi'],
                ] as [$k, $v])
                <div style="display:flex; justify-content:space-between; align-items:center; font-size:0.875rem;">
                    <span style="color:var(--text-muted);">{{ $k }}</span>
                    <span style="font-weight:600; color:var(--text);">{{ $v }}</span>
                </div>
                @endforeach
            </div>
        </div>

        <div class="alert alert-info" style="text-align:left; margin-bottom:2rem;">
            <span style="color:#2563eb; display:flex; align-items:center;"><x-icon-wa style="width:1.25rem;height:1.25rem;" /></span>
            <span>Tim kami akan menghubungi Anda via WhatsApp di nomor <strong>{{ $booking->no_hp }}</strong> dalam <strong>1×24 jam</strong>.</span>
        </div>

        <div style="display:flex; gap:0.75rem; justify-content:center; flex-wrap:wrap;">
            <a href="{{ route('katalog') }}" class="btn-navy" style="display:flex; align-items:center; justify-content:center; gap:0.5rem;"><x-icon-car style="width:1.25rem;height:1.25rem;" /> Lihat Katalog</a>
            <a href="{{ route('beranda') }}" class="btn-outline" style="display:flex; align-items:center; justify-content:center; gap:0.5rem;"><x-lucide-home style="width:1.25rem;height:1.25rem;" /> Kembali ke Beranda</a>
        </div>
    </div>
</div>
@endsection
