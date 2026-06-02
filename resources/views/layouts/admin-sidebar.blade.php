<div class="admin-overlay" id="admin-overlay"></div>
<aside class="admin-sidebar" id="admin-sidebar">
    <div class="sidebar-brand">
        <a href="{{ route('beranda') }}" style="text-decoration:none; display:flex; align-items:center; gap:0.5rem; margin-bottom:0.25rem; font-family:'Poppins',sans-serif; font-weight:800; font-size:1.05rem; color:#fff !important; white-space:nowrap;">
            @php $logo = \App\Models\Setting::get('logo_path'); @endphp
            @if($logo)
            <img src="{{ asset('storage/' . $logo) }}" alt="Logo Juragan Otomotif" style="height:26px; width:auto; object-fit:contain; flex-shrink:0;">
            @endif
            <span style="letter-spacing:0.05em; color:#fff;">JURAGAN <span style="color:var(--orange);">OTOMOTIF</span></span>
        </a>
        <p style="color:rgba(255,255,255,0.5); font-size:0.775rem; margin:0;">Panel Admin</p>
    </div>

    <nav style="padding:1rem 0; flex:1;">
        @php
            $navItems = [
                ['route' => 'admin.dashboard', 'icon' => 'layout-dashboard', 'label' => 'Dashboard'],
                ['route' => 'admin.banner.index', 'icon' => 'image', 'label' => 'Banner'],
                ['route' => 'admin.merek.index', 'icon' => 'tag', 'label' => 'Merek'],
                ['route' => 'admin.kategori.index', 'icon' => 'shapes', 'label' => 'Kategori'],
                ['route' => 'admin.mobil.index', 'icon' => 'car', 'label' => 'Mobil'],
                ['route' => 'admin.booking.index', 'icon' => 'calendar', 'label' => 'Booking'],
                ['route' => 'admin.settings', 'icon' => 'settings', 'label' => 'Pengaturan'],
            ];
        @endphp

        @foreach($navItems as $item)
        <a href="{{ route($item['route']) }}" class="admin-nav-link {{ request()->routeIs(Str::before($item['route'], '.index').'*') ? 'active' : '' }}">
            <span style="display:flex; align-items:center; justify-content:center;"><x-dynamic-component :component="'lucide-' . $item['icon']" style="width:1.25rem;height:1.25rem;" /></span> {{ $item['label'] }}
        </a>
        @endforeach

    </nav>
</aside>
