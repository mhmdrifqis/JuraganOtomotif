@extends('layouts.app')

@section('title', 'Booking Test Drive — Juragan Otomotif')
@section('meta_desc', 'Jadwalkan test drive mobil bekas pilihan Anda secara gratis. Isi formulir booking dan kami akan segera konfirmasi.')

@section('content')
<div style="max-width:800px; margin:0 auto; padding:2.5rem 1.25rem;">

    <div style="text-align:center; margin-bottom:2.5rem;">
        <h1 class="section-title" style="text-align:center; margin:0 auto 0.5rem; display:flex; align-items:center; justify-content:center; gap:0.5rem;"><x-lucide-calendar style="width:2rem;height:2rem;" /> Booking Test Drive</h1>
        <p style="color:var(--text-muted);">Isi formulir di bawah untuk menjadwalkan test drive gratis. Kami akan segera konfirmasi via WhatsApp.</p>
    </div>

    @if($errors->any())
    <div class="alert alert-error" style="margin-bottom:1.5rem;">
        <div>
            <strong style="display:flex; align-items:center; gap:0.25rem;"><x-lucide-x-circle style="width:1.25rem;height:1.25rem;" /> Ada kesalahan:</strong>
            <ul style="margin:0.5rem 0 0 1rem;">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    <div class="card-base" style="padding:2.5rem;">
        <form action="{{ route('booking.store') }}" method="POST">
            @csrf

            <div class="grid-1-2" style="display:grid; grid-template-columns:1fr 1fr; gap:1.25rem; margin-bottom:1.25rem;">
                <div>
                    <label class="form-label">Nama Lengkap <span style="color:#ef4444;">*</span></label>
                    <input type="text" name="nama_pembeli" value="{{ old('nama_pembeli') }}"
                           class="form-control {{ $errors->has('nama_pembeli') ? 'border-red-500' : '' }}"
                           placeholder="Contoh: Budi Santoso" required minlength="3">
                    @error('nama_pembeli')<p style="color:#ef4444; font-size:0.8rem; margin-top:0.25rem;">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="form-label">Nomor HP / WhatsApp <span style="color:#ef4444;">*</span></label>
                    <input type="text" name="no_hp" value="{{ old('no_hp') }}"
                           class="form-control"
                           placeholder="Contoh: 08123456789" required>
                    <p style="font-size:0.775rem; color:var(--text-muted); margin-top:0.3rem;">Format: 08xx atau 628xx</p>
                    @error('no_hp')<p style="color:#ef4444; font-size:0.8rem; margin-top:0.25rem;">{{ $message }}</p>@enderror
                </div>
            </div>

            <div style="margin-bottom:1.25rem;">
                <label class="form-label">Unit yang Diminati <span style="color:#ef4444;">*</span></label>
                <select name="mobil_id" class="form-select" required>
                    <option value="">— Pilih Unit —</option>
                    @foreach($mobils as $m)
                    <option value="{{ $m->id }}"
                        {{ old('mobil_id', $mobilItem?->id) == $m->id ? 'selected' : '' }}>
                        {{ $m->nama_mobil }} {{ $m->tahun }} — {{ $m->harga_formatted }} ({{ $m->kota }})
                    </option>
                    @endforeach
                </select>
                @error('mobil_id')<p style="color:#ef4444; font-size:0.8rem; margin-top:0.25rem;">{{ $message }}</p>@enderror
            </div>

            <div class="grid-1-2" style="display:grid; grid-template-columns:1fr 1fr; gap:1.25rem; margin-bottom:1.25rem;">
                <div>
                    <label class="form-label">Tanggal Test Drive <span style="color:#ef4444;">*</span></label>
                    <input type="date" name="tanggal_test_drive" value="{{ old('tanggal_test_drive') }}"
                           class="form-control"
                           min="{{ now()->addDay()->format('Y-m-d') }}"
                           required>
                    <p style="font-size:0.775rem; color:var(--text-muted); margin-top:0.3rem;">Minimal H+1 dari hari ini</p>
                    @error('tanggal_test_drive')<p style="color:#ef4444; font-size:0.8rem; margin-top:0.25rem;">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="form-label">Jam Preferred <span style="color:#ef4444;">*</span></label>
                    <select name="jam_preferred" class="form-select" required>
                        <option value="">— Pilih Jam —</option>
                        @foreach($slots as $value => $label)
                        <option value="{{ $value }}" {{ old('jam_preferred') === $value ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                        @endforeach
                    </select>
                    @error('jam_preferred')<p style="color:#ef4444; font-size:0.8rem; margin-top:0.25rem;">{{ $message }}</p>@enderror
                </div>
            </div>

            <div style="margin-bottom:1.75rem;">
                <label class="form-label">Catatan Tambahan</label>
                <textarea name="catatan" class="form-control" rows="3" maxlength="500"
                          placeholder="Contoh: Ingin test drive di daerah Selatan Jakarta...">{{ old('catatan') }}</textarea>
                <p style="font-size:0.775rem; color:var(--text-muted); margin-top:0.3rem;">Maksimal 500 karakter (opsional)</p>
            </div>

            {{-- Info --}}
            <div class="alert alert-info" style="margin-bottom:1.5rem;">
                <span style="display:flex; align-items:center; color:#2563eb;"><x-lucide-info style="width:1.25rem;height:1.25rem;" /></span>
                <span>Setelah submit, kami akan menghubungi Anda via WhatsApp dalam <strong>1×24 jam</strong> untuk konfirmasi jadwal.</span>
            </div>

            <button type="submit" class="btn-primary" style="width:100%; justify-content:center; font-size:1.05rem; padding:0.95rem;">
                <x-lucide-calendar style="width:1.25rem;height:1.25rem; margin-right:0.5rem;" /> Kirim Permintaan Booking
            </button>
        </form>
    </div>

    {{-- Info tambahan --}}
    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(180px, 1fr)); gap:1rem; margin-top:2rem;">
        @foreach([['check','Gratis','Tidak ada biaya booking'], ['phone','Konfirmasi Cepat','Respon dalam 1×24 jam'], ['car','Bebas Pilih','Semua unit tersedia']] as [$icon, $judul, $desc])
        <div style="text-align:center; padding:1.25rem; background:#fff; border-radius:var(--radius); border:1px solid var(--border);">
            <div style="font-size:2rem; margin-bottom:0.75rem; color:var(--orange);">
                @if($icon === 'car')
                <x-icon-car style="width:2rem;height:2rem;" />
                @else
                <x-dynamic-component :component="'lucide-' . $icon" style="width:2rem;height:2rem;" />
                @endif
            </div>
            <div style="font-family:'Poppins',sans-serif; font-weight:700; color:var(--navy); font-size:0.925rem;">{{ $judul }}</div>
            <div style="font-size:0.8rem; color:var(--text-muted); margin-top:0.25rem;">{{ $desc }}</div>
        </div>
        @endforeach
    </div>
</div>
@endsection
