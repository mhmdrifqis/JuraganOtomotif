<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — Juragan Otomotif</title>
    @if($favicon = \App\Models\Setting::get('logo_path'))
    <link rel="icon" href="{{ asset('storage/' . $favicon) }}">
    @endif
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body style="margin:0; display:flex; min-height:100vh; background:var(--bg);">

<style>
    @media (max-width: 768px) {
        .admin-sidebar { position:fixed; left:-260px; top:0; bottom:0; z-index:9999; transition:all 0.3s; display:flex !important; flex-direction:column; }
        .admin-sidebar.show { left:0; box-shadow:0 0 20px rgba(0,0,0,0.5); }
        .admin-topbar { padding: 1rem; }
        #admin-sidebar-toggle { display:block !important; }
        .admin-overlay { display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:9998; }
        .admin-overlay.show { display:block; }
        .admin-profile-info { display: none !important; }
        .admin-profile-mobile-info { display: block !important; }
        .admin-profile-mobile-info { display: block !important; }
    }
</style>

{{-- SIDEBAR --}}
@include('layouts.admin-sidebar')

{{-- MAIN --}}
<div style="flex:1; display:flex; flex-direction:column; min-width:0;">
    {{-- Topbar --}}
    @include('layouts.admin-topbar')

    {{-- Content --}}
    <div class="admin-content">
        @hasSection('topbar_actions')
        <div class="page-actions-container" style="margin-bottom: 1.5rem; display: flex; justify-content: flex-end;">
            @yield('topbar_actions')
        </div>
        @endif

        @if(session('success'))
        <div class="alert alert-success" style="display:flex; align-items:center; gap:0.5rem; margin-bottom:1.5rem;"><x-lucide-check style="width:1.25rem;height:1.25rem;" /> {{ session('success') }}</div>
        @endif
        @if(session('error'))
        <div class="alert alert-error" style="display:flex; align-items:center; gap:0.5rem; margin-bottom:1.5rem;"><x-lucide-x style="width:1.25rem;height:1.25rem;" /> {{ session('error') }}</div>
        @endif
        @if($errors->any())
        <div class="alert alert-error" style="margin-bottom:1.5rem;">
            <div><strong style="display:flex; align-items:center; gap:0.25rem;"><x-lucide-alert-circle style="width:1.25rem;height:1.25rem;" /> Terdapat kesalahan:</strong><ul style="margin:0.5rem 0 0 1.5rem;">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
        </div>
        @endif

        @yield('content')
    </div>
</div>

<script>
    // Sidebar Toggle
    const adminToggle = document.getElementById('admin-sidebar-toggle');
    const adminSidebar = document.getElementById('admin-sidebar');
    const adminOverlay = document.getElementById('admin-overlay');
    if (adminToggle) {
        adminToggle.addEventListener('click', () => {
            adminSidebar.classList.add('show');
            adminOverlay.classList.add('show');
        });
        adminOverlay.addEventListener('click', () => {
            adminSidebar.classList.remove('show');
            adminOverlay.classList.remove('show');
        });
    }

    // Profile Dropdown
    const profileBtn = document.getElementById('admin-profile-btn');
    const profileMenu = document.getElementById('admin-profile-menu');
    if (profileBtn && profileMenu) {
        profileBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            profileMenu.style.display = profileMenu.style.display === 'none' ? 'block' : 'none';
        });
        document.addEventListener('click', () => {
            profileMenu.style.display = 'none';
        });
        profileMenu.addEventListener('click', (e) => e.stopPropagation());
    }
</script>
@stack('scripts')
</body>
</html>
