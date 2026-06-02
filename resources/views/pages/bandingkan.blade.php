@extends('layouts.app')
@section('title', 'Bandingkan Mobil — Juragan Otomotif')

@section('content')
<div style="max-width:1280px; margin:0 auto; padding:2rem 1.25rem;">
    <h1 class="section-title" style="margin-bottom:0.5rem; display:flex; align-items:center; gap:0.5rem;"><x-lucide-git-compare-arrows style="width:2rem;height:2rem;" /> Bandingkan Mobil</h1>
    <p style="color:var(--text-muted); margin-bottom:2rem;">Pilih hingga 3 unit dari katalog untuk dibandingkan secara berdampingan.</p>

    @if($mobils->isEmpty())
    <div style="text-align:center; padding:4rem 2rem; background:#fff; border-radius:var(--radius-lg); border:2px dashed var(--border);">
        <div style="display:flex; justify-content:center; color:var(--text-muted); margin-bottom:1rem;"><x-lucide-git-compare-arrows style="width:4rem;height:4rem;" /></div>
        <h2 style="font-family:'Poppins',sans-serif; color:var(--navy); margin-bottom:0.5rem;">Belum Ada Unit untuk Dibandingkan</h2>
        <p style="color:var(--text-muted); margin-bottom:1.5rem;">Kunjungi katalog dan klik tombol <span style="display:inline-flex; align-items:center;"><x-lucide-git-compare-arrows style="width:1rem;height:1rem;" /></span> pada unit yang ingin Anda bandingkan.</p>
        <a href="{{ route('katalog') }}" class="btn-primary">Ke Katalog</a>
    </div>
    @else

    {{-- Tabel Perbandingan --}}
    <div style="overflow-x:auto;">
        <table style="width:100%; border-collapse:collapse; background:#fff; border-radius:var(--radius-lg); overflow:hidden; box-shadow:var(--shadow);">
            {{-- Header --}}
            <thead>
                <tr>
                    <th style="background:var(--navy); color:rgba(255,255,255,0.7); text-align:left; padding:1.25rem 1.5rem; font-family:'Poppins',sans-serif; font-size:0.875rem; font-weight:600; width:180px;">Spesifikasi</th>
                    @foreach($mobils as $m)
                    <th style="background:var(--navy); padding:1.25rem 1rem; vertical-align:top; text-align:center; min-width:240px;">
                        <a href="{{ route('mobil.show', $m->slug) }}" style="text-decoration:none;">
                            @if($m->foto_utama)
                            <img src="{{ asset('storage/' . $m->foto_utama) }}" alt="{{ $m->nama_mobil }}"
                                 style="width:100%; height:130px; object-fit:cover; border-radius:0.5rem; margin-bottom:0.75rem; border:2px solid rgba(255,255,255,0.2);">
                            @else
                            <div style="height:130px; background:rgba(255,255,255,0.1); border-radius:0.5rem; display:flex; align-items:center; justify-content:center; font-size:3rem; margin-bottom:0.75rem;">🚗</div>
                            @endif
                            <div style="color:#fff; font-family:'Poppins',sans-serif; font-weight:700; font-size:0.95rem; line-height:1.3;">{{ $m->nama_mobil }}</div>
                            <div style="color:rgba(255,255,255,0.6); font-size:0.8rem; margin-top:0.25rem;">{{ $m->merek->nama_merek }} · {{ $m->tahun }}</div>
                        </a>
                        <span class="badge-status badge-{{ $m->status }}" style="margin-top:0.5rem; display:inline-block;">{{ ucfirst($m->status) }}</span>
                    </th>
                    @endforeach
                </tr>
            </thead>

            {{-- Body --}}
            <tbody>
                {{-- Harga --}}
                @php
                    $hargaList = $mobils->pluck('harga')->toArray();
                    $minHarga  = min($hargaList);
                @endphp
                <tr style="background:#f0f7ff;">
                    <td style="padding:1rem 1.5rem; font-family:'Poppins',sans-serif; font-weight:700; color:var(--navy); font-size:0.875rem; display:flex; align-items:center; gap:0.5rem;"><x-lucide-banknote style="width:1.25rem;height:1.25rem;" /> Harga</td>
                    @foreach($mobils as $m)
                    <td style="padding:1rem; text-align:center;">
                        <div style="font-family:'Poppins',sans-serif; font-weight:800; font-size:1.1rem; color:{{ $m->harga === $minHarga ? '#15803d' : 'var(--navy)' }};">
                            {{ $m->harga_formatted }}
                            @if($m->harga === $minHarga && $mobils->count() > 1)
                            <span style="display:flex; align-items:center; gap:0.25rem; font-size:0.7rem; background:#dcfce7; color:#15803d; padding:0.15rem 0.5rem; border-radius:999px; margin-top:0.25rem;"><x-lucide-check style="width:0.875rem;height:0.875rem;" /> Termurah</span>
                            @endif
                        </div>
                        @if($m->bisa_nego)<div style="font-size:0.775rem; color:var(--orange); font-weight:600; margin-top:0.2rem;">Bisa Nego</div>@endif
                    </td>
                    @endforeach
                </tr>

                @php
                    $fieldRows = [
                        ['labelIcon' => 'calendar', 'label' => 'Tahun', 'field' => 'tahun', 'format' => 'integer', 'highlight' => 'max'],
                        ['labelIcon' => 'hash', 'label' => 'Kilometer', 'field' => 'kilometer', 'format' => 'number_format', 'highlight' => 'min'],
                        ['labelIcon' => 'settings', 'label' => 'Transmisi', 'field' => 'transmisi', 'format' => 'ucfirst', 'highlight' => null],
                        ['labelIcon' => 'fuel', 'label' => 'Bahan Bakar', 'field' => 'bahan_bakar', 'format' => 'ucfirst', 'highlight' => null],
                        ['labelIcon' => 'wrench', 'label' => 'Kapasitas Mesin', 'field' => 'kapasitas_mesin', 'format' => 'cc', 'highlight' => null],
                        ['labelIcon' => 'tag', 'label' => 'Kategori', 'field' => 'kategori', 'format' => 'text', 'highlight' => null],
                        ['labelIcon' => 'palette', 'label' => 'Warna', 'field' => 'warna', 'format' => 'text', 'highlight' => null],
                        ['labelIcon' => 'map-pin', 'label' => 'Kota', 'field' => 'kota', 'format' => 'text', 'highlight' => null],
                    ];
                @endphp

                @foreach($fieldRows as $idx => $row)
                @php
                    $labelIcon = $row['labelIcon'];
                    $label = $row['label'];
                    $field = $row['field'];
                    $format = $row['format'];
                    $highlight = $row['highlight'];
                @endphp
                <tr style="{{ $idx % 2 === 0 ? '' : 'background:#f8fafc;' }}">
                    <td style="padding:1rem 1.5rem; font-weight:600; color:var(--text-muted); font-size:0.875rem; display:flex; align-items:center; gap:0.5rem;"><x-dynamic-component :component="'lucide-'.$labelIcon" style="width:1.25rem;height:1.25rem;" /> {{ $label }}</td>
                    @php
                        if ($highlight === 'min') $best = $mobils->min($field);
                        elseif ($highlight === 'max') $best = $mobils->max($field);
                        else $best = null;
                    @endphp
                    @foreach($mobils as $m)
                    @php
                        $val = $m->$field;
                        $display = match($format) {
                            'number_format' => number_format($val, 0, ',', '.') . ' km',
                            'ucfirst' => ucfirst($val),
                            'cc' => number_format($val, 0, ',', '.') . ' cc',
                            default => $val,
                        };
                        $isBest = $best !== null && $val === $best && $mobils->count() > 1;
                    @endphp
                    <td style="padding:0.875rem 1rem; text-align:center; font-weight:{{ $isBest ? '700' : '500' }}; color:{{ $isBest ? '#15803d' : 'var(--text)' }}; font-size:0.9rem;">
                        {{ $display }}
                        @if($isBest)
                        <span style="display:flex; align-items:center; gap:0.25rem; font-size:0.7rem; color:#15803d;"><x-lucide-check style="width:0.875rem;height:0.875rem;" /> Terbaik</span>
                        @endif
                    </td>
                    @endforeach
                </tr>
                @endforeach

                {{-- CTA Row --}}
                <tr>
                    <td style="padding:1.25rem 1.5rem; font-family:'Poppins',sans-serif; font-weight:600; color:var(--text-muted); font-size:0.85rem;">Aksi</td>
                    @foreach($mobils as $m)
                    <td style="padding:1.25rem 1rem; text-align:center;">
                        @php
                            $waNum = \App\Models\Setting::get('whatsapp_number');
                            $waMsg = urlencode("Halo, saya tertarik dengan {$m->nama_mobil} {$m->tahun}. Bisa info lebih lanjut?");
                        @endphp
                        <div style="display:flex; flex-direction:column; gap:0.5rem; align-items:center;">
                            <a href="{{ route('mobil.show', $m->slug) }}" class="btn-navy btn-sm" style="width:100%; justify-content:center;">Detail</a>
                            <a href="https://wa.me/{{ $waNum }}?text={{ $waMsg }}" target="_blank" class="btn-wa btn-sm" style="width:100%; justify-content:center; display:flex; align-items:center; gap:0.25rem;"><x-icon-wa style="width:1rem;height:1rem;" /> WhatsApp</a>
                            <a href="{{ route('booking.create', ['mobil_id' => $m->id]) }}" class="btn-outline btn-sm" style="width:100%; justify-content:center; display:flex; align-items:center; gap:0.25rem;"><x-lucide-calendar style="width:1rem;height:1rem;" /> Booking</a>
                        </div>
                    </td>
                    @endforeach
                </tr>
            </tbody>
        </table>
    </div>

    <div style="text-align:center; margin-top:2rem;">
        <a href="{{ route('katalog') }}" class="btn-outline">← Kembali ke Katalog</a>
    </div>
    @endif
</div>
@endsection
