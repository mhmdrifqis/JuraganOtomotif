@extends('layouts.admin')

@section('title', isset($mobil) ? 'Edit Unit' : 'Tambah Unit')
@section('page_title', isset($mobil) ? 'Edit Unit: ' . $mobil->nama_mobil : 'Tambah Unit Baru')

@section('content')

<form action="{{ isset($mobil) ? route('admin.mobil.update', $mobil) : route('admin.mobil.store') }}"
      method="POST" enctype="multipart/form-data">
    @csrf
    @if(isset($mobil)) @method('PUT') @endif

    <div class="admin-grid-layout">

        {{-- KIRI: Detail Unit --}}
        <div style="display:flex; flex-direction:column; gap:1.5rem;">

            {{-- Informasi Dasar --}}
            <div class="card-base" style="padding:1.75rem;">
                <h3 style="font-family:'Poppins',sans-serif; font-weight:700; color:var(--navy); font-size:1rem; margin-bottom:1.25rem; display:flex; align-items:center; gap:0.5rem;"><x-lucide-clipboard-list style="width:1.25rem;height:1.25rem;" /> Informasi Dasar</h3>
                <div class="admin-grid-form">
                    <div>
                        <label class="form-label">Merek <span style="color:#ef4444;">*</span></label>
                        <select name="merek_id" class="form-select" required>
                            <option value="">-- Pilih Merek --</option>
                            @foreach($mereks as $m)
                            <option value="{{ $m->id }}" {{ old('merek_id', $mobil->merek_id ?? '') == $m->id ? 'selected' : '' }}>{{ $m->nama_merek }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Kategori <span style="color:#ef4444;">*</span></label>
                        <select name="kategori_id" class="form-select" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($kategoris as $k)
                            <option value="{{ $k->id }}" {{ old('kategori_id', $mobil->kategori_id ?? '') == $k->id ? 'selected' : '' }}>{{ $k->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div style="grid-column:1/-1;">
                        <label class="form-label">Nama Unit / Tipe <span style="color:#ef4444;">*</span></label>
                        <input type="text" name="nama_mobil" value="{{ old('nama_mobil', $mobil->nama_mobil ?? '') }}" class="form-control" placeholder="Contoh: Avanza 1.3 G MT" required>
                    </div>
                    <div>
                        <label class="form-label">Kota / Lokasi <span style="color:#ef4444;">*</span></label>
                        <input type="text" name="kota" value="{{ old('kota', $mobil->kota ?? '') }}" class="form-control" placeholder="Jakarta Selatan" required>
                    </div>
                    <div>
                        <label class="form-label">Warna <span style="color:#ef4444;">*</span></label>
                        <input type="text" name="warna" value="{{ old('warna', $mobil->warna ?? '') }}" class="form-control" placeholder="Putih, Hitam, Silver..." required>
                    </div>
                </div>
            </div>

            {{-- Spesifikasi --}}
            <div class="card-base" style="padding:1.75rem;">
                <h3 style="font-family:'Poppins',sans-serif; font-weight:700; color:var(--navy); font-size:1rem; margin-bottom:1.25rem; display:flex; align-items:center; gap:0.5rem;"><x-lucide-settings style="width:1.25rem;height:1.25rem;" /> Spesifikasi</h3>
                <div class="admin-grid-form">
                    <div>
                        <label class="form-label">Tahun <span style="color:#ef4444;">*</span></label>
                        <input type="number" name="tahun" value="{{ old('tahun', $mobil->tahun ?? '') }}" class="form-control" min="1990" max="{{ date('Y')+1 }}" required>
                    </div>
                    <div>
                        <label class="form-label">Kilometer (KM) <span style="color:#ef4444;">*</span></label>
                        <input type="number" name="kilometer" value="{{ old('kilometer', $mobil->kilometer ?? '') }}" class="form-control" min="0" required>
                    </div>
                    <div>
                        <label class="form-label">Transmisi <span style="color:#ef4444;">*</span></label>
                        <select name="transmisi" class="form-select" required>
                            @foreach($transmisis as $t)
                            <option value="{{ $t }}" {{ old('transmisi', $mobil->transmisi ?? '') === $t ? 'selected' : '' }}>{{ ucfirst($t) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Bahan Bakar <span style="color:#ef4444;">*</span></label>
                        <select name="bahan_bakar" class="form-select" required>
                            @foreach($bahanBakars as $b)
                            <option value="{{ $b }}" {{ old('bahan_bakar', $mobil->bahan_bakar ?? '') === $b ? 'selected' : '' }}>{{ ucfirst($b) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Kapasitas Mesin (CC) <span style="color:#ef4444;">*</span></label>
                        <input type="number" name="kapasitas_mesin" value="{{ old('kapasitas_mesin', $mobil->kapasitas_mesin ?? '') }}" class="form-control" min="600" max="10000" required>
                    </div>
                </div>
            </div>

            {{-- Deskripsi --}}
            <div class="card-base" style="padding:1.75rem;">
                <h3 style="font-family:'Poppins',sans-serif; font-weight:700; color:var(--navy); font-size:1rem; margin-bottom:1.25rem; display:flex; align-items:center; gap:0.5rem;"><x-lucide-file-text style="width:1.25rem;height:1.25rem;" /> Deskripsi</h3>
                <textarea name="deskripsi" class="form-control" rows="5" maxlength="2000" placeholder="Kondisi unit, kelengkapan surat, catatan penting...">{{ old('deskripsi', $mobil->deskripsi ?? '') }}</textarea>
                <p style="font-size:0.775rem; color:var(--text-muted); margin-top:0.35rem;">Maksimal 2000 karakter (opsional)</p>
            </div>

            {{-- Upload Foto --}}
            <div class="card-base" style="padding:1.75rem;">
                <h3 style="font-family:'Poppins',sans-serif; font-weight:700; color:var(--navy); font-size:1rem; margin-bottom:1.25rem; display:flex; align-items:center; gap:0.5rem;"><x-lucide-camera style="width:1.25rem;height:1.25rem;" /> Foto Unit</h3>

                <div style="margin-bottom:1.25rem;">
                    <label class="form-label">Foto Utama (Cover)</label>
                    @if(isset($mobil) && $mobil->foto_utama)
                    <div style="margin-bottom:0.75rem;">
                        <img src="{{ asset('storage/'.$mobil->foto_utama) }}" alt="Foto Utama" style="height:120px; border-radius:0.5rem; border:2px solid var(--border);">
                    </div>
                    @endif
                    <input type="file" name="foto_utama" class="form-control" accept="image/*" style="padding:0.5rem;">
                    <p style="font-size:0.775rem; color:var(--text-muted); margin-top:0.3rem;">Format: JPG, PNG, WebP. Maks 5MB.</p>
                </div>

                <div>
                    <label class="form-label">Foto Galeri (Multiple)</label>
                    @if(isset($mobil) && $mobil->foto_galeri)
                    <div style="display:flex; flex-wrap:wrap; gap:0.5rem; margin-bottom:0.75rem;">
                        @foreach($mobil->foto_galeri as $foto)
                        <div style="position:relative;">
                            <img src="{{ asset('storage/'.$foto) }}" alt="Galeri" style="height:80px; border-radius:0.4rem; border:1px solid var(--border);">
                            <label style="position:absolute; top:-4px; right:-4px; width:20px; height:20px; background:#ef4444; color:#fff; border-radius:50%; display:flex; align-items:center; justify-content:center; cursor:pointer; font-size:0.75rem;" title="Hapus foto ini">
                                <input type="checkbox" name="hapus_foto[]" value="{{ $foto }}" style="display:none;"><x-lucide-trash-2 style="width:1rem;height:1rem;" />
                            </label>
                        </div>
                        @endforeach
                    </div>
                    <p style="font-size:0.775rem; color:var(--text-muted); margin-bottom:0.5rem;">Klik icon tempat sampah untuk menghapus foto</p>
                    @endif
                    <input type="file" name="foto_galeri[]" class="form-control" accept="image/*" multiple style="padding:0.5rem;">
                    <p style="font-size:0.775rem; color:var(--text-muted); margin-top:0.3rem;">Pilih beberapa foto sekaligus. Maks 5MB/foto.</p>
                </div>
            </div>

        </div>

        {{-- KANAN: Harga & Status --}}
        <div style="display:flex; flex-direction:column; gap:1.25rem; position:sticky; top:80px;">

            <div class="card-base" style="padding:1.5rem;">
                <h3 style="font-family:'Poppins',sans-serif; font-weight:700; color:var(--navy); font-size:1rem; margin-bottom:1.25rem; display:flex; align-items:center; gap:0.5rem;"><x-lucide-banknote style="width:1.25rem;height:1.25rem;" /> Harga & Status</h3>

                <div style="margin-bottom:1rem;">
                    <label class="form-label">Harga (Rupiah) <span style="color:#ef4444;">*</span></label>
                    <input type="number" name="harga" value="{{ old('harga', $mobil->harga ?? '') }}" class="form-control" min="1" placeholder="150000000" required>
                </div>

                <div style="margin-bottom:1rem;">
                    <label style="display:flex; align-items:center; gap:0.5rem; cursor:pointer; font-family:'Poppins',sans-serif; font-weight:500; font-size:0.9rem;">
                        <input type="checkbox" name="bisa_nego" value="1" {{ old('bisa_nego', $mobil->bisa_nego ?? false) ? 'checked' : '' }} style="accent-color:var(--orange); width:16px; height:16px;">
                        Harga Bisa Nego
                    </label>
                </div>

                <div class="divider"></div>

                <div style="margin-bottom:1rem;">
                    <label class="form-label">Status Unit <span style="color:#ef4444;">*</span></label>
                    <select name="status" class="form-select" required>
                        @foreach($statuses as $s)
                        <option value="{{ $s }}" {{ old('status', $mobil->status ?? 'tersedia') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label style="display:flex; align-items:center; gap:0.5rem; cursor:pointer; font-family:'Poppins',sans-serif; font-weight:500; font-size:0.9rem;">
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $mobil->is_featured ?? false) ? 'checked' : '' }} style="accent-color:var(--orange); width:16px; height:16px;">
                        <x-lucide-star style="width:1.25rem;height:1.25rem;color:var(--orange);" /> Jadikan Unit Unggulan
                    </label>
                    <p style="font-size:0.775rem; color:var(--text-muted); margin-top:0.25rem; margin-left:1.5rem;">Tampil di halaman beranda</p>
                </div>
            </div>

            <div style="display:flex; flex-direction:column; gap:0.75rem;">
                <button type="submit" class="btn-primary" style="width:100%; justify-content:center; padding:0.875rem;">
                    @if(isset($mobil)) <span style="display:flex; align-items:center; gap:0.25rem;"><x-lucide-save style="width:1.25rem;height:1.25rem;" /> Simpan Perubahan</span> @else <span style="display:flex; align-items:center; gap:0.25rem;"><x-lucide-check-circle style="width:1.25rem;height:1.25rem;" /> Tambah Unit</span> @endif
                </button>
                <a href="{{ route('admin.mobil.index') }}" class="btn-outline" style="width:100%; justify-content:center; display:flex; align-items:center; gap:0.5rem;"><x-lucide-arrow-left style="width:1.25rem;height:1.25rem;" /> Batal</a>
            </div>
        </div>

    </div>
</form>

@endsection
