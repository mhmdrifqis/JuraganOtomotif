<div class="admin-topbar" style="display:flex; align-items:center; gap:1rem;">
    <button id="admin-sidebar-toggle" style="display:none; background:none; border:none; color:var(--navy); cursor:pointer; padding:0; flex-shrink:0;">
        <x-lucide-menu style="width:1.5rem;height:1.5rem;" />
    </button>
    <div style="flex:1; min-width:0;">
        <h1 style="font-family:'Poppins',sans-serif; font-weight:700; font-size:1.1rem; color:var(--navy); margin:0; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">@yield('page_title', 'Dashboard')</h1>
        @hasSection('breadcrumb')
        <nav style="font-size:0.8rem; color:var(--text-muted); margin-top:0.15rem;">@yield('breadcrumb')</nav>
        @endif
    </div>
    <div style="display:flex; align-items:center; gap:1.25rem;">
        
        <a href="{{ route('beranda') }}" target="_blank" title="Website" class="btn-globe" style="display:inline-flex; align-items:center; justify-content:center; padding:0.4rem; text-decoration:none;">
            <x-lucide-globe style="width:1.25rem; height:1.25rem; transition:color 0.2s ease;" class="globe-icon" />
        </a>            <div style="width:1px; height:24px; background:var(--border);"></div>
        
        <div style="position:relative;" id="admin-profile-dropdown">
            <button id="admin-profile-btn" style="display:flex; align-items:center; gap:0.5rem; background:none; border:none; cursor:pointer; padding:0;">
                <div style="width:36px; height:36px; border-radius:50%; background:var(--navy); color:#fff; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:1rem;">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div class="admin-profile-info" style="text-align:left; display:block;">
                    <div style="font-weight:600; font-size:0.875rem; color:var(--navy); line-height:1.2;">{{ Auth::user()->name }}</div>
                    <div style="font-size:0.75rem; color:var(--text-muted);">Admin</div>
                </div>
                <x-lucide-chevron-down style="width:1rem;height:1rem; color:var(--text-muted);" />
            </button>

            <div id="admin-profile-menu" style="display:none; position:absolute; right:0; top:calc(100% + 10px); width:180px; background:#fff; border:1px solid var(--border); border-radius:0.5rem; box-shadow:var(--shadow-lg); overflow:hidden; z-index:100;">
                <div class="admin-profile-mobile-info" style="display:none; padding:1rem; border-bottom:1px solid var(--border); text-align:left;">
                    <div style="font-weight:600; font-size:0.875rem; color:var(--navy); line-height:1.2;">{{ Auth::user()->name }}</div>
                    <div style="font-size:0.75rem; color:var(--text-muted);">Admin</div>
                </div>
                <a href="{{ route('profile.edit') }}" style="display:flex; align-items:center; gap:0.5rem; padding:0.75rem 1rem; color:var(--text); text-decoration:none; font-size:0.875rem; border-bottom:1px solid var(--border);">
                    <x-lucide-user style="width:1.1rem;height:1.1rem;" /> Profil
                </a>
                <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                    @csrf
                    <button type="submit" style="width:100%; display:flex; align-items:center; gap:0.5rem; padding:0.75rem 1rem; color:#ef4444; background:none; border:none; text-align:left; cursor:pointer; font-size:0.875rem;">
                        <x-lucide-log-out style="width:1.1rem;height:1.1rem;" /> Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
