@extends('layouts.app')
@section('title', 'Login - Juragan Otomotif')

@section('content')
<div style="min-height:80vh; display:flex; align-items:center; justify-content:center; padding:4rem 1.25rem; background:#f8fafc; background-image:radial-gradient(#e2e8f0 1px, transparent 1px); background-size:20px 20px;">
    <div style="background:#fff; border-radius:1rem; box-shadow:0 20px 50px -12px rgba(0,0,0,0.1); width:100%; max-width:450px; overflow:hidden; position:relative;">
        <div style="position:absolute; top:0; left:0; width:100%; height:4px; background:linear-gradient(90deg, var(--orange), #f9a826);"></div>
        <div style="padding:2.5rem; text-align:center; border-bottom:1px solid #f1f5f9;">
            @php $logo = \App\Models\Setting::get('logo_path'); @endphp
            @if($logo)
            <img src="{{ asset('storage/' . $logo) }}" alt="Logo Juragan Otomotif" style="height:48px; width:auto; object-fit:contain; margin:0 auto 0.5rem;">
            @else
            <div style="display:inline-flex; align-items:center; justify-content:center; width:64px; height:64px; border-radius:50%; background:var(--bg); color:var(--navy); margin-bottom:0.5rem; box-shadow:0 4px 10px rgba(0,0,0,0.05);">
                <x-lucide-user style="width:2rem;height:2rem;" />
            </div>
            @endif
            <div style="font-family:'Poppins',sans-serif; font-weight:800; font-size:1.25rem; color:var(--navy); letter-spacing:0.05em; margin-bottom:1.25rem;">JURAGAN <span style="color:var(--orange);">OTOMOTIF</span></div>
            <h1 style="font-family:'Poppins',sans-serif; font-weight:800; color:var(--navy); font-size:1.75rem; margin-bottom:0.5rem;">Selamat Datang</h1>
            <p style="color:var(--text-muted); font-size:0.95rem;">Masuk ke akun Juragan Otomotif Anda</p>
        </div>
        <div style="padding:2.5rem;">
            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" style="display:flex; flex-direction:column; gap:1.25rem;">
                @csrf
                <input type="text" name="username_hp" style="display:none;" tabindex="-1" autocomplete="off">
                <div>
                    <label style="display:block; font-size:0.875rem; font-weight:600; color:var(--navy); margin-bottom:0.5rem;">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus style="width:100%; padding:0.875rem 1rem; border:1px solid #cbd5e1; border-radius:0.5rem; outline:none; transition:border-color 0.2s, box-shadow 0.2s; background:#f8fafc;" onfocus="this.style.borderColor='var(--orange)'; this.style.boxShadow='0 0 0 3px rgba(232,130,26,0.1)';" onblur="this.style.borderColor='#cbd5e1'; this.style.boxShadow='none';">
                    @error('email') <span style="color:#ef4444; font-size:0.8rem; margin-top:0.25rem; display:block;">{{ $message }}</span> @enderror
                </div>

                <div>
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:0.5rem;">
                        <label style="font-size:0.875rem; font-weight:600; color:var(--navy);">Password</label>
                        @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" style="font-size:0.8rem; color:var(--orange); text-decoration:none; font-weight:500;">Lupa Password?</a>
                        @endif
                    </div>
                    <input type="password" name="password" required style="width:100%; padding:0.875rem 1rem; border:1px solid #cbd5e1; border-radius:0.5rem; outline:none; transition:border-color 0.2s, box-shadow 0.2s; background:#f8fafc;" onfocus="this.style.borderColor='var(--orange)'; this.style.boxShadow='0 0 0 3px rgba(232,130,26,0.1)';" onblur="this.style.borderColor='#cbd5e1'; this.style.boxShadow='none';">
                    @error('password') <span style="color:#ef4444; font-size:0.8rem; margin-top:0.25rem; display:block;">{{ $message }}</span> @enderror
                </div>

                <div style="display:flex; align-items:center; gap:0.5rem; margin-top:0.25rem;">
                    <input type="checkbox" name="remember" id="remember" style="accent-color:var(--orange); width:1rem; height:1rem; border-radius:0.25rem; cursor:pointer;">
                    <label for="remember" style="font-size:0.875rem; color:var(--text-muted); cursor:pointer;">Ingat Saya</label>
                </div>

                <button type="submit" class="btn-primary" style="width:100%; justify-content:center; padding:1rem; font-size:1.05rem; font-weight:700; margin-top:0.75rem; box-shadow:0 4px 15px rgba(232,130,26,0.3);">
                    Masuk Sekarang
                </button>
            </form>
        </div>
        <div style="padding:1.5rem; background:#f8fafc; text-align:center; border-top:1px solid #f1f5f9;">
            <p style="font-size:0.9rem; color:var(--text-muted);">Belum punya akun? <a href="{{ route('register') }}" style="color:var(--orange); font-weight:600; text-decoration:none; display:inline-flex; align-items:center; gap:0.2rem;">Daftar di sini <x-lucide-arrow-right style="width:0.8rem;height:0.8rem;" /></a></p>
        </div>
    </div>
</div>
@endsection
