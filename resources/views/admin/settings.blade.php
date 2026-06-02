@extends('layouts.admin')

@section('title', 'Pengaturan Platform')
@section('page_title', 'Pengaturan Platform')

@section('content')

<form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="admin-grid-2-col">

        {{-- WhatsApp & Sosmed --}}
        <div class="card-base" style="padding:1.75rem;">
            <h3 style="font-family:'Poppins',sans-serif; font-weight:700; color:var(--navy); font-size:1rem; margin-bottom:1.25rem;">WhatsApp & Media Sosial</h3>

            <div style="margin-bottom:1.25rem;">
                <label class="form-label">Logo Website</label>
                @if(!empty($settings['logo_path']))
                <div style="margin-bottom:0.75rem;">
                    <img src="{{ asset('storage/'.$settings['logo_path']) }}" alt="Logo" style="height:60px; object-fit:contain; border-radius:0.25rem; background:#f1f5f9; padding:0.5rem; border:1px solid var(--border);">
                </div>
                @endif
                <input type="file" name="logo" class="form-control" accept="image/*" style="padding:0.5rem;">
                <p style="font-size:0.775rem; color:var(--text-muted); margin-top:0.3rem;">Format: JPG, PNG, WebP, SVG. Maks 2MB.</p>
            </div>

            <div class="divider"></div>

            <div style="margin-bottom:1.1rem;">
                <label class="form-label">Nomor WhatsApp Aktif <span style="color:#ef4444;">*</span></label>
                <input type="text" name="whatsapp_number" value="{{ $settings['whatsapp_number'] }}" class="form-control" placeholder="6281234567890" required>
                <p style="font-size:0.775rem; color:var(--text-muted); margin-top:0.3rem;">Format: 62xxx (tanpa +, tanpa spasi). Contoh: 6281234567890</p>
            </div>

            <div style="margin-bottom:1.1rem;">
                <label class="form-label">Template Pesan WhatsApp</label>
                <textarea name="whatsapp_message" class="form-control" rows="3" maxlength="500">{{ $settings['whatsapp_message'] }}</textarea>
                <p style="font-size:0.775rem; color:var(--text-muted); margin-top:0.3rem;">Gunakan <code>[Nama Mobil]</code> dan <code>[Tahun]</code> sebagai placeholder.</p>
            </div>

            <div class="divider"></div>

            <div style="margin-bottom:1.1rem;">
                <label class="form-label">URL Instagram</label>
                <input type="url" name="instagram_url" value="{{ $settings['instagram_url'] }}" class="form-control" placeholder="https://instagram.com/juraganotomotif">
            </div>

            <div>
                <label class="form-label">URL TikTok</label>
                <input type="url" name="tiktok_url" value="{{ $settings['tiktok_url'] }}" class="form-control" placeholder="https://tiktok.com/@juraganotomotif">
            </div>
        </div>

        {{-- Hero & Toko --}}
        <div class="card-base" style="padding:1.75rem;">
            <h3 style="font-family:'Poppins',sans-serif; font-weight:700; color:var(--navy); font-size:1rem; margin-bottom:1.25rem;">Konten Beranda & Toko</h3>

            <div style="margin-bottom:1.1rem;">
                <label class="form-label">Judul Hero (Beranda) <span style="color:#ef4444;">*</span></label>
                <input type="text" name="hero_title" value="{{ $settings['hero_title'] }}" class="form-control" maxlength="100" required>
            </div>

            <div style="margin-bottom:1.1rem;">
                <label class="form-label">Sub-judul Hero <span style="color:#ef4444;">*</span></label>
                <textarea name="hero_subtitle" class="form-control" rows="2" maxlength="200" required>{{ $settings['hero_subtitle'] }}</textarea>
            </div>

            <div class="divider"></div>

            <div style="margin-bottom:1.1rem;">
                <label class="form-label">Alamat Showroom</label>
                <textarea name="alamat" class="form-control" rows="2" maxlength="300">{{ $settings['alamat'] }}</textarea>
            </div>

            <div>
                <label class="form-label">Jam Operasional</label>
                <input type="text" name="jam_operasional" value="{{ $settings['jam_operasional'] }}" class="form-control" placeholder="Senin - Sabtu: 08.00 - 17.00 WIB">
            </div>
        </div>

        {{-- SEO --}}
        <div class="card-base" style="padding:1.75rem; grid-column:1/-1;">
            <h3 style="font-family:'Poppins',sans-serif; font-weight:700; color:var(--navy); font-size:1rem; margin-bottom:1.25rem;">SEO Settings</h3>
            <div class="admin-grid-form">
                <div>
                    <label class="form-label">Meta Title — Beranda</label>
                    <input type="text" name="meta_title_home" value="{{ $settings['meta_title_home'] }}" class="form-control" maxlength="70" placeholder="Max 70 karakter">
                    <p style="font-size:0.775rem; color:var(--text-muted); margin-top:0.25rem;">Rekomendasi: 50-70 karakter</p>
                </div>
                <div>
                    <label class="form-label">Meta Description — Beranda</label>
                    <textarea name="meta_desc_home" class="form-control" rows="2" maxlength="160" placeholder="Max 160 karakter">{{ $settings['meta_desc_home'] }}</textarea>
                    <p style="font-size:0.775rem; color:var(--text-muted); margin-top:0.25rem;">Rekomendasi: 120-160 karakter</p>
                </div>
            </div>
        </div>

    </div>

    <div style="margin-top:1.5rem; display:flex; gap:1rem;">
        <button type="submit" class="btn-primary" style="padding:0.875rem 2.5rem; font-size:1rem;">
            Simpan Semua Pengaturan
        </button>
    </div>
</form>

@endsection
