<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- SEO --}}
    <title>@yield('title', config('app.name'))</title>
    @if($favicon = \App\Models\Setting::get('logo_path'))
    <link rel="icon" href="{{ asset('storage/' . $favicon) }}">
    @endif
    <meta name="description" content="@yield('meta_desc', \App\Models\Setting::get('meta_desc_home'))">
    <meta name="robots" content="index, follow">

    {{-- Open Graph --}}
    <meta property="og:title" content="@yield('title', config('app.name'))">
    <meta property="og:description" content="@yield('meta_desc', \App\Models\Setting::get('meta_desc_home'))">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="id_ID">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body x-data="{ openLoginDrawer: {{ $errors->has('email') || $errors->has('password') || session('status') ? 'true' : 'false' }} }">

{{-- NAVBAR --}}
<nav class="navbar" id="navbar">
    <div style="max-width:1280px; margin:0 auto; padding:0 1.25rem; display:flex; align-items:center; justify-content:space-between; height:64px;">

        <a href="{{ route('beranda') }}" class="navbar-brand" style="text-decoration:none; display:flex; align-items:center; gap:0.5rem; font-family:'Poppins',sans-serif; font-weight:800; font-size:1.2rem; color:#fff !important;">
            @php $logo = \App\Models\Setting::get('logo_path'); @endphp
            @if($logo)
            <img src="{{ asset('storage/' . $logo) }}" alt="Logo Juragan Otomotif" style="height:28px; width:auto; object-fit:contain;">
            @endif
            <span class="brand-text" style="letter-spacing:0.05em; color:#fff;">JURAGAN <span style="color:var(--orange);">OTOMOTIF</span></span>
        </a>

        <div style="display:flex; align-items:center; gap:0.25rem;" class="desktop-nav">
            <a href="{{ route('beranda') }}" class="nav-link {{ request()->routeIs('beranda') ? 'active' : '' }}">Beranda</a>
            <a href="{{ route('katalog') }}" class="nav-link {{ request()->routeIs('katalog') ? 'active' : '' }}">Katalog</a>
            <a href="{{ route('bandingkan') }}" class="nav-link {{ request()->routeIs('bandingkan') ? 'active' : '' }}">Bandingkan</a>
            @auth
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="nav-link" style="color:var(--orange) !important; display:inline-flex; align-items:center; gap:0.25rem;"><x-lucide-shield-user class="w-4 h-4" style="width:1rem;height:1rem;" /> Admin Dashboard</a>
                    <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="nav-link" style="background:none; border:none; cursor:pointer; font-size:inherit; font-family:inherit; padding:0; display:inline-flex; align-items:center; gap:0.25rem;"><x-lucide-log-out class="w-4 h-4" style="width:1rem;height:1rem;" /> Logout</button>
                    </form>
                @else
                    <div style="position:relative;" x-data="{ openProfile: false }" @click.away="openProfile = false">
                        <button @click="openProfile = !openProfile" style="display:flex; align-items:center; gap:0.5rem; background:none; border:none; cursor:pointer; padding:0; margin-left:0.5rem; margin-right:0.5rem;">
                            <div style="width:36px; height:36px; border-radius:50%; background:var(--orange); color:#fff; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:1rem; box-shadow:0 4px 10px rgba(232,130,26,0.3);">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                        </button>
                        
                        <div x-show="openProfile" x-cloak style="display:none; position:absolute; right:0; top:calc(100% + 15px); width:200px; background:#fff; border:1px solid #e2e8f0; border-radius:0.75rem; box-shadow:0 10px 25px rgba(0,0,0,0.1); overflow:hidden; z-index:100;" x-transition>
                            <div style="padding:1rem; border-bottom:1px solid #e2e8f0;">
                                <div style="font-weight:700; font-size:0.9rem; color:var(--navy); line-height:1.2; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">{{ Auth::user()->name }}</div>
                                <div style="font-size:0.75rem; color:var(--text-muted);">{{ Auth::user()->phone ?? 'Customer' }}</div>
                            </div>
                            <a href="{{ route('profile.edit') }}" style="display:flex; align-items:center; gap:0.5rem; padding:0.75rem 1rem; color:var(--text); text-decoration:none; font-size:0.875rem; border-bottom:1px solid #e2e8f0; transition:background 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                                <x-lucide-user style="width:1.1rem;height:1.1rem; color:var(--orange);" /> Profil Saya
                            </a>
                            <a href="{{ route('booking.history') }}" style="display:flex; align-items:center; gap:0.5rem; padding:0.75rem 1rem; color:var(--text); text-decoration:none; font-size:0.875rem; border-bottom:1px solid #e2e8f0; transition:background 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                                <x-lucide-calendar-check style="width:1.1rem;height:1.1rem; color:var(--orange);" /> Riwayat Booking
                            </a>
                            <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                                @csrf
                                <button type="submit" style="width:100%; display:flex; align-items:center; gap:0.5rem; padding:0.75rem 1rem; color:#ef4444; background:none; border:none; text-align:left; cursor:pointer; font-size:0.875rem; transition:background 0.2s;" onmouseover="this.style.background='#fef2f2'" onmouseout="this.style.background='transparent'">
                                    <x-lucide-log-out style="width:1.1rem;height:1.1rem;" /> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @endif
            @else
                <a href="#" @click.prevent="openLoginDrawer = true" class="nav-link" style="color:var(--orange) !important; display:inline-flex; align-items:center; gap:0.25rem;"><x-lucide-log-in class="w-4 h-4" style="width:1rem;height:1rem;" /> Login</a>
            @endauth
        </div>

        <button id="nav-toggle" style="display:none; background:none; border:none; color:#fff; cursor:pointer; padding:0.25rem;" aria-label="Menu">
            <svg width="26" height="26" fill="currentColor" viewBox="0 0 24 24"><path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z"/></svg>
        </button>
    </div>

    <div id="mobile-nav" style="display:none; position:absolute; top:100%; left:0; right:0; margin-top:0.5rem; padding:1rem 1.25rem; border:1px solid rgba(255,255,255,0.1); border-radius:1rem; background:var(--navy-light); box-shadow:0 10px 40px rgba(0,0,0,0.4); z-index:999;">
        <a href="{{ route('beranda') }}" class="nav-link" style="display:block; padding:0.75rem 0 !important; border-bottom:1px solid rgba(255,255,255,0.05);">Beranda</a>
        <a href="{{ route('katalog') }}" class="nav-link" style="display:block; padding:0.75rem 0 !important; border-bottom:1px solid rgba(255,255,255,0.05);">Katalog</a>
        <a href="{{ route('bandingkan') }}" class="nav-link" style="display:block; padding:0.75rem 0 !important; border-bottom:1px solid rgba(255,255,255,0.05);">Bandingkan</a>
        
        @auth
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="nav-link" style="display:block; padding:0.75rem 0 !important; color:var(--orange) !important; border-bottom:1px solid rgba(255,255,255,0.05);"><x-lucide-shield-user class="w-4 h-4" style="width:1rem;height:1rem; display:inline-block; vertical-align:middle; margin-right:0.25rem;" /> Admin Dashboard</a>
                <form action="{{ route('logout') }}" method="POST" style="margin:0;">
                    @csrf
                    <button type="submit" class="nav-link" style="width:100%; text-align:left; background:none; border:none; padding:0.75rem 0 !important; cursor:pointer; color:#ef4444 !important; border-bottom:1px solid rgba(255,255,255,0.05);"><x-lucide-log-out class="w-4 h-4" style="width:1rem;height:1rem; display:inline-block; vertical-align:middle; margin-right:0.25rem;" /> Logout</button>
                </form>
            @else
                <div style="padding:0.75rem 0; border-bottom:1px solid rgba(255,255,255,0.05);">
                    <div style="font-weight:700; color:#fff;">{{ Auth::user()->name }}</div>
                    <div style="font-size:0.75rem; color:rgba(255,255,255,0.6);">{{ Auth::user()->phone ?? 'Customer' }}</div>
                </div>
                <a href="{{ route('profile.edit') }}" class="nav-link" style="display:block; padding:0.75rem 0 !important; border-bottom:1px solid rgba(255,255,255,0.05);"><x-lucide-user style="width:1rem;height:1rem; display:inline-block; vertical-align:middle; margin-right:0.25rem;" /> Profil Saya</a>
                <a href="{{ route('booking.history') }}" class="nav-link" style="display:block; padding:0.75rem 0 !important; border-bottom:1px solid rgba(255,255,255,0.05);"><x-lucide-calendar-check style="width:1rem;height:1rem; display:inline-block; vertical-align:middle; margin-right:0.25rem;" /> Riwayat Booking</a>
                <form action="{{ route('logout') }}" method="POST" style="margin:0;">
                    @csrf
                    <button type="submit" class="nav-link" style="width:100%; text-align:left; background:none; border:none; padding:0.75rem 0 !important; cursor:pointer; color:#ef4444 !important; border-bottom:1px solid rgba(255,255,255,0.05);"><x-lucide-log-out class="w-4 h-4" style="width:1rem;height:1rem; display:inline-block; vertical-align:middle; margin-right:0.25rem;" /> Logout</button>
                </form>
            @endif
        @else
            <a href="#" @click.prevent="openLoginDrawer = true; mobileNav.style.display = 'none'" class="nav-link" style="display:block; padding:0.75rem 0 !important; color:var(--orange) !important; border-bottom:1px solid rgba(255,255,255,0.05);"><x-lucide-log-in class="w-4 h-4" style="width:1rem;height:1rem; display:inline-block; vertical-align:middle; margin-right:0.25rem;" /> Login</a>
        @endauth
    </div>
</nav>

@if(session('success'))
<div style="max-width:1280px; margin:0.75rem auto; padding:0 1.25rem;">
    <div class="alert alert-success" style="display:flex; align-items:center; gap:0.5rem;"><x-lucide-check style="width:1.25rem;height:1.25rem;" /> {{ session('success') }}</div>
</div>
@endif
@if(session('error'))
<div style="max-width:1280px; margin:0.75rem auto; padding:0 1.25rem;">
    <div class="alert alert-error" style="display:flex; align-items:center; gap:0.5rem;"><x-lucide-x style="width:1.25rem;height:1.25rem;" /> {{ session('error') }}</div>
</div>
@endif

@yield('content')

{{-- FOOTER --}}
<footer class="footer" style="padding:3rem 0 2rem; margin-top:4rem;">
    <div style="max-width:1280px; margin:0 auto; padding:0 1.25rem;">
        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px, 1fr)); gap:2rem; margin-bottom:2rem;">
            <div>
                <div style="font-family:'Poppins',sans-serif; font-weight:800; color:#fff; font-size:1.2rem; margin-bottom:0.75rem; display:flex; align-items:center; gap:0.5rem;">
                    @php $logo = \App\Models\Setting::get('logo_path'); @endphp
                    @if($logo)
                    <img src="{{ asset('storage/' . $logo) }}" alt="Logo Juragan Otomotif" style="height:28px; width:auto; object-fit:contain;">
                    @endif
                    <span style="letter-spacing:0.05em;">JURAGAN <span style="color:var(--orange);">OTOMOTIF</span></span>
                </div>
                <p style="font-size:0.875rem; color:rgba(255,255,255,0.7); line-height:1.7;">
                    Platform jual beli mobil bekas terpercaya. Temukan mobil impian Anda dengan mudah, aman, dan harga transparan.
                </p>
            </div>
            <div>
                <h4 style="color:#fff; font-size:0.95rem; font-family:'Poppins',sans-serif; font-weight:600; margin-bottom:1rem;">Navigasi</h4>
                @foreach(['beranda'=>'Beranda','katalog'=>'Katalog Mobil','bandingkan'=>'Bandingkan'] as $r => $l)
                <a href="{{ route($r) }}" style="display:block; color:rgba(255,255,255,0.7); text-decoration:none; font-size:0.875rem; padding:0.2rem 0; transition:color 0.2s;" onmouseover="this.style.color='var(--orange)'" onmouseout="this.style.color='rgba(255,255,255,0.7)'">{{ $l }}</a>
                @endforeach
            </div>
            <div>
                <h4 style="color:#fff; font-size:0.95rem; font-family:'Poppins',sans-serif; font-weight:600; margin-bottom:1rem;">Media Sosial</h4>
                @php $ig = \App\Models\Setting::get('instagram_url'); $tk = \App\Models\Setting::get('tiktok_url'); $wa = \App\Models\Setting::get('whatsapp_number'); @endphp
                <div style="display:flex; flex-direction:column; gap:0.75rem;">
                    @if($ig)<a href="{{ $ig }}" target="_blank" style="color:rgba(255,255,255,0.7); text-decoration:none; display:flex; align-items:center; gap:0.5rem; transition:color 0.2s;" onmouseover="this.style.color='var(--orange)'" onmouseout="this.style.color='rgba(255,255,255,0.7)'"> Instagram</a>@endif
                    @if($tk)<a href="{{ $tk }}" target="_blank" style="color:rgba(255,255,255,0.7); text-decoration:none; display:flex; align-items:center; gap:0.5rem; transition:color 0.2s;" onmouseover="this.style.color='var(--orange)'" onmouseout="this.style.color='rgba(255,255,255,0.7)'">TikTok</a>@endif
                    @if($wa)<a href="https://wa.me/{{ $wa }}" target="_blank" style="color:rgba(255,255,255,0.7); text-decoration:none; display:flex; align-items:center; gap:0.5rem; transition:color 0.2s;" onmouseover="this.style.color='var(--orange)'" onmouseout="this.style.color='rgba(255,255,255,0.7)'"> WhatsApp</a>@endif
                </div>
            </div>
            <div>
                <h4 style="color:#fff; font-size:0.95rem; font-family:'Poppins',sans-serif; font-weight:600; margin-bottom:1rem;">Tentang Juragan Otomotif</h4>
                <a href="{{ route('tentang') }}" style="display:inline-flex; align-items:center; gap:0.25rem; color:rgba(255,255,255,0.7); text-decoration:none; font-size:0.875rem; transition:color 0.2s;" onmouseover="this.style.color='var(--orange)'" onmouseout="this.style.color='rgba(255,255,255,0.7)'"> Tentang </a>
            </div>
        </div>
        <div style="border-top:1px solid rgba(255,255,255,0.1); padding-top:1.25rem; text-align:center;">
            <p style="font-size:0.825rem; color:rgba(255,255,255,0.45);">© {{ date('Y') }} Juragan Otomotif. All rights reserved. <br>
                Developed by <a href="https://github.com/mhmdrifqis" target="_blank" class="underline" style="color:rgba(255,255,255,0.7); text-decoration:none;" onmouseover="this.style.color='var(--orange)'" onmouseout="this.style.color='rgba(255,255,255,0.7)'">221011400528 Muhammad Rifqi Saifulloh </a>
                and <a href="https://wa.me/+6281380459670" target="_blank" class="underline" style="color:rgba(255,255,255,0.7); text-decoration:none;" onmouseover="this.style.color='var(--orange)'" onmouseout="this.style.color='rgba(255,255,255,0.7)'">221011402031 Ahmad Baihaqi</a>.

            </p>
        </div>
    </div>
</footer>

<!-- {{-- Floating WA Button --}}
@if(isset($wa) && $wa)
<a href="https://wa.me/{{ $wa }}" target="_blank" class="wa-float" title="Chat via WhatsApp">
    <x-icon-wa style="width:2.25rem;height:2.25rem;" />
</a>
@endif -->



<script>
const toggle = document.getElementById('nav-toggle');
const mobileNav = document.getElementById('mobile-nav');
const desktopNav = document.querySelector('.desktop-nav');
function checkNav() {
    if (window.innerWidth <= 768) { toggle.style.display='block'; desktopNav.style.display='none'; }
    else { toggle.style.display='none'; desktopNav.style.display='flex'; mobileNav.style.display='none'; }
}
checkNav(); window.addEventListener('resize', checkNav);
toggle?.addEventListener('click', () => { mobileNav.style.display = mobileNav.style.display === 'none' ? 'block' : 'none'; });
window.addEventListener('scroll', () => {
    const nav = document.getElementById('navbar');
    if (window.scrollY > 20) {
        nav.style.boxShadow = 'none';
        nav.classList.add('navbar-floating');
    } else {
        nav.style.boxShadow = '0 2px 20px rgba(0,0,0,0.15)';
        nav.classList.remove('navbar-floating');
    }
});
</script>
@stack('scripts')
<script>
function showToast(message, type = 'success') {
    let toast = document.createElement('div');
    toast.textContent = message;
    toast.style.position = 'fixed';
    toast.style.bottom = '20px';
    toast.style.right = '20px';
    toast.style.backgroundColor = type === 'success' ? '#1e293b' : '#ef4444';
    toast.style.color = '#fff';
    toast.style.padding = '12px 20px';
    toast.style.borderRadius = '8px';
    toast.style.boxShadow = '0 4px 6px rgba(0,0,0,0.1)';
    toast.style.zIndex = '9999';
    toast.style.fontFamily = "'Poppins', sans-serif";
    toast.style.fontSize = '0.9rem';
    toast.style.opacity = '0';
    toast.style.transform = 'translateY(20px)';
    toast.style.transition = 'all 0.3s ease';
    document.body.appendChild(toast);
    setTimeout(() => { toast.style.opacity = '1'; toast.style.transform = 'translateY(0)'; }, 10);
    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transform = 'translateY(20px)';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}
</script>
<div x-show="openLoginDrawer" style="display:none;" x-cloak>
    <div style="position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:9998;" @click="openLoginDrawer = false" x-transition.opacity></div>
    
    <div style="position:fixed; top:0; bottom:0; right:0; width:100%; max-width:400px; background:#fff; z-index:9999; box-shadow:-5px 0 25px rgba(0,0,0,0.1); padding:2rem; overflow-y:auto; display:flex; flex-direction:column;"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="transform translate-x-full"
         x-transition:enter-end="transform translate-x-0"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="transform translate-x-0"
         x-transition:leave-end="transform translate-x-full">
        
        <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:2rem;">
            <div>
                <div style="display:flex; align-items:center; gap:0.5rem; margin-bottom:0.5rem;">
                    @php $logo = \App\Models\Setting::get('logo_path'); @endphp
                    @if($logo)
                    <img src="{{ asset('storage/' . $logo) }}" alt="Logo Juragan Otomotif" style="height:24px; width:auto; object-fit:contain;">
                    @endif
                    <span style="font-family:'Poppins',sans-serif; font-weight:800; font-size:1rem; color:var(--navy); letter-spacing:0.05em;">JURAGAN <span style="color:var(--orange);">OTOMOTIF</span></span>
                </div>
                <h2 style="font-family:'Poppins',sans-serif; font-weight:800; color:var(--navy); font-size:1.5rem;">Masuk</h2>
            </div>
            <button @click="openLoginDrawer = false" style="background:none; border:none; font-size:1.5rem; cursor:pointer; color:var(--text-muted);">&times;</button>
        </div>

        <form method="POST" action="{{ route('login') }}" style="display:flex; flex-direction:column; gap:1.25rem; flex-grow:1;">
            @csrf
            <input type="text" name="username_hp" style="display:none;" tabindex="-1" autocomplete="off">
            <div>
                <label style="display:block; font-size:0.875rem; font-weight:600; color:var(--navy); margin-bottom:0.5rem;">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required style="width:100%; padding:0.75rem 1rem; border:1px solid {{ $errors->has('email') ? '#ef4444' : 'var(--border)' }}; border-radius:0.5rem; font-family:inherit; outline:none;" onfocus="this.style.borderColor='var(--orange)'" onblur="this.style.borderColor='{{ $errors->has('email') ? '#ef4444' : 'var(--border)' }}'">
                @error('email')<div style="color:#ef4444; font-size:0.8rem; margin-top:0.35rem;">Email atau password yang Anda masukkan salah atau tidak terdaftar.</div>@enderror
            </div>
            <div>
                <label style="display:block; font-size:0.875rem; font-weight:600; color:var(--navy); margin-bottom:0.5rem;">Password</label>
                <input type="password" name="password" required style="width:100%; padding:0.75rem 1rem; border:1px solid {{ $errors->has('email') ? '#ef4444' : 'var(--border)' }}; border-radius:0.5rem; font-family:inherit; outline:none;" onfocus="this.style.borderColor='var(--orange)'" onblur="this.style.borderColor='{{ $errors->has('email') ? '#ef4444' : 'var(--border)' }}'">
            </div>
            <div style="display:flex; justify-content:space-between; align-items:center; font-size:0.875rem;">
                <label style="display:flex; align-items:center; gap:0.5rem; cursor:pointer; color:var(--text-muted);">
                    <input type="checkbox" name="remember" style="accent-color:var(--orange);"> Ingat saya
                </label>
                @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" style="color:var(--orange); text-decoration:none; font-weight:500;">Lupa Password?</a>
                @endif
            </div>
            <button type="submit" class="btn-primary" style="width:100%; justify-content:center; padding:0.875rem; font-size:1rem; margin-top:0.5rem;">Login</button>
        </form>
        
        <div style="text-align:center; margin-top:2rem; font-size:0.875rem; color:var(--text-muted);">
            Belum punya akun? <br>
            <a href="{{ route('register') }}" style="color:var(--orange); font-weight:600; text-decoration:none; display:inline-block; margin-top:0.25rem;">Daftar di sini</a>
        </div>
    </div>
</div>

</body>
</html>
