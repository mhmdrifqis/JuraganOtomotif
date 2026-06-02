@extends('layouts.app')
@section('title', 'Daftar - Juragan Otomotif')

@section('content')
<div style="min-height:80vh; display:flex; align-items:center; justify-content:center; padding:4rem 1.25rem; background:#f8fafc; background-image:radial-gradient(#e2e8f0 1px, transparent 1px); background-size:20px 20px;">
    <div style="background:#fff; border-radius:1rem; box-shadow:0 20px 50px -12px rgba(0,0,0,0.1); width:100%; max-width:600px; overflow:hidden; position:relative;">
        <div style="position:absolute; top:0; left:0; width:100%; height:4px; background:linear-gradient(90deg, var(--orange), #f9a826);"></div>
        <div style="padding:2.5rem 2.5rem 1.5rem; text-align:center; border-bottom:1px solid #f1f5f9;">
            @php $logo = \App\Models\Setting::get('logo_path'); @endphp
            @if($logo)
            <img src="{{ asset('storage/' . $logo) }}" alt="Logo Juragan Otomotif" style="height:48px; width:auto; object-fit:contain; margin:0 auto 1.25rem;">
            @else
            <div style="display:inline-flex; align-items:center; justify-content:center; width:64px; height:64px; border-radius:50%; background:var(--bg); color:var(--navy); margin-bottom:1.25rem; box-shadow:0 4px 10px rgba(0,0,0,0.05);">
                <x-lucide-user-plus style="width:2rem;height:2rem;" />
            </div>
            @endif
            <h1 style="font-family:'Poppins',sans-serif; font-weight:800; color:var(--navy); font-size:1.75rem; margin-bottom:0.5rem;">Daftar Akun Baru</h1>
            <p style="color:var(--text-muted); font-size:0.95rem;">Bergabunglah dengan ribuan pelanggan Juragan Otomotif lainnya</p>
        </div>
        <div style="padding:2rem 2.5rem 2.5rem;">
            <form method="POST" action="{{ route('register') }}" style="display:flex; flex-direction:column; gap:1.25rem;">
                @csrf
                
                <div>
                    <label style="display:block; font-size:0.875rem; font-weight:600; color:var(--navy); margin-bottom:0.5rem;">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}" required autofocus style="width:100%; padding:0.875rem 1rem; border:1px solid #cbd5e1; border-radius:0.5rem; outline:none; transition:border-color 0.2s, box-shadow 0.2s; background:#f8fafc;" onfocus="this.style.borderColor='var(--orange)'; this.style.boxShadow='0 0 0 3px rgba(232,130,26,0.1)';" onblur="this.style.borderColor='#cbd5e1'; this.style.boxShadow='none';">
                    @error('name') <span style="color:#ef4444; font-size:0.8rem; margin-top:0.25rem; display:block;">{{ $message }}</span> @enderror
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:1.25rem;">
                    <div>
                        <label style="display:block; font-size:0.875rem; font-weight:600; color:var(--navy); margin-bottom:0.5rem;">Email Address</label>
                        <input type="email" name="email" value="{{ old('email') }}" required style="width:100%; padding:0.875rem 1rem; border:1px solid #cbd5e1; border-radius:0.5rem; outline:none; transition:border-color 0.2s, box-shadow 0.2s; background:#f8fafc;" onfocus="this.style.borderColor='var(--orange)'; this.style.boxShadow='0 0 0 3px rgba(232,130,26,0.1)';" onblur="this.style.borderColor='#cbd5e1'; this.style.boxShadow='none';">
                        @error('email') <span style="color:#ef4444; font-size:0.8rem; margin-top:0.25rem; display:block;">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label style="display:block; font-size:0.875rem; font-weight:600; color:var(--navy); margin-bottom:0.5rem;">No. WhatsApp</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" required style="width:100%; padding:0.875rem 1rem; border:1px solid #cbd5e1; border-radius:0.5rem; outline:none; transition:border-color 0.2s, box-shadow 0.2s; background:#f8fafc;" onfocus="this.style.borderColor='var(--orange)'; this.style.boxShadow='0 0 0 3px rgba(232,130,26,0.1)';" onblur="this.style.borderColor='#cbd5e1'; this.style.boxShadow='none';">
                        @error('phone') <span style="color:#ef4444; font-size:0.8rem; margin-top:0.25rem; display:block;">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:1.25rem;">
                    <div>
                        <label style="display:block; font-size:0.875rem; font-weight:600; color:var(--navy); margin-bottom:0.5rem;">Password</label>
                        <input type="password" name="password" required style="width:100%; padding:0.875rem 1rem; border:1px solid #cbd5e1; border-radius:0.5rem; outline:none; transition:border-color 0.2s, box-shadow 0.2s; background:#f8fafc;" onfocus="this.style.borderColor='var(--orange)'; this.style.boxShadow='0 0 0 3px rgba(232,130,26,0.1)';" onblur="this.style.borderColor='#cbd5e1'; this.style.boxShadow='none';">
                        @error('password') <span style="color:#ef4444; font-size:0.8rem; margin-top:0.25rem; display:block;">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label style="display:block; font-size:0.875rem; font-weight:600; color:var(--navy); margin-bottom:0.5rem;">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" required style="width:100%; padding:0.875rem 1rem; border:1px solid #cbd5e1; border-radius:0.5rem; outline:none; transition:border-color 0.2s, box-shadow 0.2s; background:#f8fafc;" onfocus="this.style.borderColor='var(--orange)'; this.style.boxShadow='0 0 0 3px rgba(232,130,26,0.1)';" onblur="this.style.borderColor='#cbd5e1'; this.style.boxShadow='none';">
                    </div>
                </div>

                <button type="submit" class="btn-primary" style="width:100%; justify-content:center; padding:1rem; font-size:1.05rem; font-weight:700; margin-top:0.75rem; box-shadow:0 4px 15px rgba(232,130,26,0.3);">
                    Daftar Sekarang
                </button>
            </form>
        </div>
        <div style="padding:1.5rem; background:#f8fafc; text-align:center; border-top:1px solid #f1f5f9;">
            <p style="font-size:0.9rem; color:var(--text-muted);">Sudah punya akun? <a href="{{ route('login') }}" style="color:var(--orange); font-weight:600; text-decoration:none; display:inline-flex; align-items:center; gap:0.2rem;">Masuk di sini <x-lucide-arrow-right style="width:0.8rem;height:0.8rem;" /></a></p>
        </div>
    </div>
</div>
@endsection
