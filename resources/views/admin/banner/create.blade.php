@extends('layouts.admin')
@section('title', 'Tambah Banner')

@section('content')
<div style="max-width:800px; margin:0 auto;">
    <div style="display:flex; align-items:center; gap:1rem; margin-bottom:1.5rem;">
        <a href="{{ route('admin.banner.index') }}" class="btn-outline" style="padding:0.5rem; border-radius:0.5rem;"><x-lucide-arrow-left style="width:1.25rem;height:1.25rem;" /></a>
        <h2 style="font-family:'Poppins',sans-serif; font-size:1.5rem; font-weight:700; color:var(--navy); margin:0;">Tambah Banner</h2>
    </div>

    <form action="{{ route('admin.banner.store') }}" method="POST" enctype="multipart/form-data" class="card" style="background:#fff; border-radius:var(--radius-lg); border:1px solid var(--border); padding:2rem;">
        @csrf
        <div style="display:grid; gap:1.5rem;">
            <div class="form-group">
                <label style="display:block; font-weight:600; color:var(--navy); margin-bottom:0.5rem;">Gambar Banner (Background) <span style="color:#dc2626">*</span></label>
                <p style="font-size:0.8rem; color:var(--text-muted); margin-bottom:0.5rem;">Rekomendasi ukuran: 1920x1080 atau orientasi mendatar (landscape).</p>
                <input type="file" name="image" required accept="image/*" class="form-control" style="width:100%; padding:0.75rem; border:1px solid var(--border); border-radius:var(--radius); font-family:inherit;">
            </div>

            <div class="form-group">
                <label style="display:block; font-weight:600; color:var(--navy); margin-bottom:0.5rem;">Judul Utama (Title) - Opsional</label>
                <p style="font-size:0.8rem; color:var(--text-muted); margin-bottom:0.5rem;">Gunakan format HTML sederhana (misal <code>&lt;span&gt;Mobil Bekas&lt;/span&gt;</code> untuk warna oranye). Biarkan kosong jika ingin menggunakan teks bawaan.</p>
                <input type="text" name="title" value="{{ old('title') }}" class="form-control" style="width:100%; padding:0.75rem; border:1px solid var(--border); border-radius:var(--radius); font-family:inherit;">
            </div>

            <div class="form-group">
                <label style="display:block; font-weight:600; color:var(--navy); margin-bottom:0.5rem;">Sub-judul (Subtitle) - Opsional</label>
                <input type="text" name="subtitle" value="{{ old('subtitle') }}" class="form-control" style="width:100%; padding:0.75rem; border:1px solid var(--border); border-radius:var(--radius); font-family:inherit;">
            </div>

            <div style="display:grid; grid-template-columns:1fr 1fr; gap:1.5rem;">
                <div class="form-group">
                    <label style="display:block; font-weight:600; color:var(--navy); margin-bottom:0.5rem;">Urutan (Makin kecil makin awal) <span style="color:#dc2626">*</span></label>
                    <input type="number" name="urutan" value="{{ old('urutan', 0) }}" required class="form-control" style="width:100%; padding:0.75rem; border:1px solid var(--border); border-radius:var(--radius); font-family:inherit;">
                </div>
                <div class="form-group" style="display:flex; align-items:flex-end;">
                    <label style="display:flex; align-items:center; gap:0.5rem; font-weight:600; color:var(--navy); padding-bottom:0.75rem; cursor:pointer;">
                        <input type="checkbox" name="is_active" value="1" checked style="width:1.25rem; height:1.25rem; accent-color:var(--orange);">
                        Banner Aktif (Tampilkan)
                    </label>
                </div>
            </div>

            <div style="margin-top:1rem; text-align:right;">
                <button type="submit" class="btn-primary" style="padding:0.75rem 2rem; font-size:1rem; display:inline-flex; align-items:center; gap:0.5rem;">
                    <x-lucide-save style="width:1.25rem;height:1.25rem;" /> Simpan Banner
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
