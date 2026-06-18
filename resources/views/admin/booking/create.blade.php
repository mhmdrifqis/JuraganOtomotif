@extends('layouts.admin')
@section('title', 'Tambah Booking Manual')

@section('content')
<div class="admin-content">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:2rem;">
        <h1 style="font-family:'Poppins',sans-serif; font-weight:800; color:var(--navy); font-size:1.75rem; margin-bottom:0; display:flex; align-items:center; gap:0.5rem;"><x-lucide-calendar-plus style="width:2rem;height:2rem; color:var(--orange);" /> Tambah Booking (Manual)</h1>
        <a href="{{ route('admin.booking.index') }}" class="btn-outline">Kembali</a>
    </div>

    <div style="background:#fff; border-radius:var(--radius-lg); padding:2rem; box-shadow:var(--shadow);">
        <form action="{{ route('admin.booking.store') }}" method="POST">
            @csrf

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:1.5rem; margin-bottom:1.5rem;" class="admin-grid-form">
                <div>
                    <label style="display:block; font-size:0.875rem; font-weight:600; color:var(--navy); margin-bottom:0.5rem;">Unit Mobil <span style="color:red;">*</span></label>
                    <select name="mobil_id" required style="width:100%; padding:0.75rem 1rem; border:1px solid var(--border); border-radius:0.5rem; font-family:inherit; outline:none;">
                        <option value="">-- Pilih Mobil --</option>
                        @foreach($mobils as $m)
                        <option value="{{ $m->id }}" {{ old('mobil_id') == $m->id ? 'selected' : '' }}>{{ $m->nama_mobil }} ({{ $m->tahun }}) - {{ $m->harga_formatted }}</option>
                        @endforeach
                    </select>
                    @error('mobil_id')<div style="color:red; font-size:0.8rem; margin-top:0.25rem;">{{ $message }}</div>@enderror
                </div>

                <div>
                    <label style="display:block; font-size:0.875rem; font-weight:600; color:var(--navy); margin-bottom:0.5rem;">Nama Pembeli / Customer <span style="color:red;">*</span></label>
                    <input type="text" name="nama_pembeli" value="{{ old('nama_pembeli') }}" required placeholder="Nama lengkap customer" style="width:100%; padding:0.75rem 1rem; border:1px solid var(--border); border-radius:0.5rem; font-family:inherit; outline:none;">
                    @error('nama_pembeli')<div style="color:red; font-size:0.8rem; margin-top:0.25rem;">{{ $message }}</div>@enderror
                </div>

                <div>
                    <label style="display:block; font-size:0.875rem; font-weight:600; color:var(--navy); margin-bottom:0.5rem;">No. WhatsApp <span style="color:red;">*</span></label>
                    <input type="text" name="no_hp" value="{{ old('no_hp') }}" required placeholder="Misal: 08123456789" style="width:100%; padding:0.75rem 1rem; border:1px solid var(--border); border-radius:0.5rem; font-family:inherit; outline:none;">
                    @error('no_hp')<div style="color:red; font-size:0.8rem; margin-top:0.25rem;">{{ $message }}</div>@enderror
                </div>

                <div>
                    <label style="display:block; font-size:0.875rem; font-weight:600; color:var(--navy); margin-bottom:0.5rem;">Tanggal Test Drive <span style="color:red;">*</span></label>
                    <input type="date" name="tanggal_test_drive" value="{{ old('tanggal_test_drive') }}" required min="{{ date('Y-m-d') }}" style="width:100%; padding:0.75rem 1rem; border:1px solid var(--border); border-radius:0.5rem; font-family:inherit; outline:none;">
                    @error('tanggal_test_drive')<div style="color:red; font-size:0.8rem; margin-top:0.25rem;">{{ $message }}</div>@enderror
                </div>

                <div>
                    <label style="display:block; font-size:0.875rem; font-weight:600; color:var(--navy); margin-bottom:0.5rem;">Jam Test Drive <span style="color:red;">*</span></label>
                    <select name="jam_preferred" required style="width:100%; padding:0.75rem 1rem; border:1px solid var(--border); border-radius:0.5rem; font-family:inherit; outline:none;">
                        <option value="">-- Pilih Jam --</option>
                        @foreach($slotJam as $key => $val)
                        <option value="{{ $key }}" {{ old('jam_preferred') == $key ? 'selected' : '' }}>{{ $val }}</option>
                        @endforeach
                    </select>
                    @error('jam_preferred')<div style="color:red; font-size:0.8rem; margin-top:0.25rem;">{{ $message }}</div>@enderror
                </div>
                
                <div style="grid-column: 1 / -1;">
                    <label style="display:block; font-size:0.875rem; font-weight:600; color:var(--navy); margin-bottom:0.5rem;">Catatan Khusus</label>
                    <textarea name="catatan" rows="3" placeholder="Misal: Customer sudah janji lewat WA dan ingin langsung nego di tempat." style="width:100%; padding:0.75rem 1rem; border:1px solid var(--border); border-radius:0.5rem; font-family:inherit; outline:none;">{{ old('catatan') }}</textarea>
                    @error('catatan')<div style="color:red; font-size:0.8rem; margin-top:0.25rem;">{{ $message }}</div>@enderror
                </div>
            </div>

            <div style="text-align:right; border-top:1px solid var(--border); padding-top:1.5rem; margin-top:1.5rem;">
                <button type="submit" class="btn-primary" style="padding:0.875rem 2.5rem; font-size:1rem;">Simpan Booking</button>
            </div>
        </form>
    </div>
</div>
@endsection
