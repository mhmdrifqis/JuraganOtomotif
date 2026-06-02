@extends('layouts.app')

@section('title', \App\Models\Setting::get('meta_title_home'))
@section('meta_desc', \App\Models\Setting::get('meta_desc_home'))

@section('content')

{{-- HERO --}}
<section class="hero" style="padding:5rem 0 4rem; position:relative; overflow:hidden;" 
         x-data="{ currentBanner: 0, count: {{ $banners->count() > 0 ? $banners->count() : 1 }} }" 
         x-init="if(count > 1) { setInterval(() => { currentBanner = (currentBanner + 1) % count }, 5000); }">
    
    {{-- Background Slider --}}
    @if($banners->count() > 0)
        @foreach($banners as $index => $banner)
        <div x-show="currentBanner === {{ $index }}" 
             x-transition.opacity.duration.1000ms 
             style="position:absolute; inset:0; background-image:url('{{ asset('storage/' . $banner->image_path) }}'); background-size:cover; background-position:center; z-index:0; {{ $index !== 0 ? 'display:none;' : '' }}">
            <div style="position:absolute; inset:0; background:rgba(15,23,42,0.75);"></div>
        </div>
        @endforeach
    @else
        <div style="position:absolute; inset:0; z-index:0; background:linear-gradient(135deg, var(--navy) 0%, var(--navy-light) 60%, #1a4a7a 100%);">
            <div style="position:absolute; inset:0; background:url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'0.03\'%3E%3Ccircle cx=\'30\' cy=\'30\' r=\'4\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E'); opacity:0.5;"></div>
        </div>
    @endif

    <div style="max-width:1280px; margin:0 auto; padding:0 1.25rem; position:relative; z-index:1;">
        <div class="hero-grid-layout">
            <div class="animate-fade-in-up">
                <div style="display:inline-flex; align-items:center; gap:0.5rem; background:rgba(232,130,26,0.2); border:1px solid rgba(232,130,26,0.4); border-radius:999px; padding:0.35rem 1rem; margin-bottom:1.25rem;">
                    <span style="width:8px; height:8px; border-radius:50%; background:var(--orange); display:inline-block; animation:waPulse 2s infinite;"></span>
                    <span style="color:var(--orange); font-size:0.825rem; font-weight:600; font-family:'Poppins',sans-serif;">{{ $totalUnit }} Unit Tersedia Sekarang</span>
                </div>

                <div style="position: relative; min-height: 230px; margin-bottom: 1rem;"> {{-- Position relative to hold absolute texts --}}
                    @if($banners->count() > 0)
                        @foreach($banners as $index => $banner)
                        <div x-show="currentBanner === {{ $index }}" x-transition.opacity.duration.800ms style="position: absolute; top: 0; left: 0; width: 100%; {{ $index !== 0 ? 'display:none;' : '' }}">
                            <h1 class="hero-title">
                                {!! $banner->title ? str_replace(' ', ' ', $banner->title) : str_replace(' ', ' ', \App\Models\Setting::get('hero_title', 'Temukan <span>Mobil Bekas</span> Impian Anda')) !!}
                            </h1>
                            <p class="hero-subtitle" style="margin:1.25rem 0 2rem;">
                                {{ $banner->subtitle ? $banner->subtitle : \App\Models\Setting::get('hero_subtitle') }}
                            </p>
                        </div>
                        @endforeach
                    @else
                        <h1 class="hero-title">
                            {!! str_replace(' ', ' ', \App\Models\Setting::get('hero_title', 'Temukan <span>Mobil Bekas</span> Impian Anda')) !!}
                        </h1>
                        <p class="hero-subtitle" style="margin:1.25rem 0 2rem;">
                            {{ \App\Models\Setting::get('hero_subtitle') }}
                        </p>
                    @endif
                </div>

                <div style="display:flex; gap:1rem; flex-wrap:wrap; margin-top: 1rem;">
                    <a href="{{ route('katalog') }}" class="btn-primary" style="font-size:1rem; padding:0.875rem 2rem; display:flex; align-items:center; gap:0.5rem;">
                        <x-icon-car style="width:1.25rem;height:1.25rem;" /> Lihat Semua Katalog
                    </a>
                    <a href="{{ route('booking.create') }}" class="btn-outline" style="color:#fff; border-color:rgba(255,255,255,0.4); font-size:1rem; padding:0.875rem 2rem; display:flex; align-items:center; gap:0.5rem;" onmouseover="this.style.background='rgba(255,255,255,0.15)'" onmouseout="this.style.background='transparent'">
                        <x-lucide-calendar style="width:1.25rem;height:1.25rem;" /> Booking Test Drive
                    </a>
                </div>
            </div>

            {{-- Stats cards --}}
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;">
                <div class="stat-card animate-fade-in-up" style="animation-delay:0.1s">
                    <div class="stat-number">{{ $totalUnit }}</div>
                    <div class="stat-label">Unit Tersedia</div>
                </div>
                <div class="stat-card animate-fade-in-up" style="animation-delay:0.2s">
                    <div class="stat-number">{{ $totalMerek }}</div>
                    <div class="stat-label">Merek Pilihan</div>
                </div>
                <div class="stat-card animate-fade-in-up" style="animation-delay:0.3s">
                    <div class="stat-number">100%</div>
                    <div class="stat-label">Unit Bergaransi</div>
                </div>
                <div class="stat-card animate-fade-in-up" style="animation-delay:0.4s">
                    <div class="stat-number" style="display:flex; align-items:center; justify-content:center; gap:0.25rem;"><x-lucide-star style="width:2rem;height:2rem;color:var(--orange);" /> 4.9</div>
                    <div class="stat-label">Rating Pembeli</div>
                </div>
            </div>
        </div>

        {{-- Quick Search --}}
        <div style="background:rgba(255,255,255,0.1); backdrop-filter:blur(12px); border:1px solid rgba(255,255,255,0.2); border-radius:var(--radius-lg); padding:1.25rem 1.5rem; margin-top:3rem;">
            <form action="{{ route('katalog') }}" method="GET" class="hero-search-form" style="display:flex; gap:1rem; flex-wrap:wrap; align-items:flex-end;">
                <div style="flex:2; min-width:200px;">
                    <label class="form-label" style="color:rgba(255,255,255,0.9);">Cari Mobil</label>
                    <input type="text" name="search" placeholder="Contoh: Toyota Avanza, Honda Jazz..." class="form-control" style="border-color:rgba(255,255,255,0.3); background:rgba(255,255,255,0.15); color:#fff;" oninput="this.style.borderColor='var(--orange)'">
                </div>
                <div style="flex:1; min-width:140px;">
                    <label class="form-label" style="color:rgba(255,255,255,0.9);">Kategori</label>
                    <select name="kategori[]" class="form-select" style="border-color:rgba(255,255,255,0.3); background:rgba(255,255,255,0.15); color:#fff;">
                        <option value="" style="color:#333;">Semua Kategori</option>
                        @foreach($kategoriList as $k)
                        <option value="{{ $k->slug }}" style="color:#333;">{{ $k->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>
                <div style="flex:1; min-width:140px;">
                    <label class="form-label" style="color:rgba(255,255,255,0.9);">Transmisi</label>
                    <select name="transmisi" class="form-select" style="border-color:rgba(255,255,255,0.3); background:rgba(255,255,255,0.15); color:#fff;">
                        <option value="" style="color:#333;">Semua</option>
                        <option value="manual" style="color:#333;">Manual</option>
                        <option value="matic" style="color:#333;">Matic</option>
                    </select>
                </div>
                <button type="submit" class="btn-primary" style="white-space:nowrap; padding:0.7rem 1.75rem; display:flex; align-items:center; gap:0.5rem;"><x-lucide-search style="width:1.25rem;height:1.25rem;" /> Cari Sekarang</button>
            </form>
        </div>
    </div>
</section>

{{-- KATEGORI CEPAT --}}
@if($kategoriList->isNotEmpty())
<section style="padding:3rem 0 0; background:#fff;">
    <div style="max-width:1280px; margin:0 auto; padding:0 1.25rem;">
        <h2 class="section-title" style="text-align:center; margin-bottom:2rem;">Jelajahi Berdasarkan Kategori Mobil</h2>
        <div class="hide-scrollbar" style="display:flex; gap:0.75rem; overflow-x:auto; padding-bottom:1rem; scroll-snap-type:x mandatory;">
            @foreach($kategoriList as $kat)
            <a href="{{ route('katalog', ['kategori[]' => $kat->slug]) }}" style="flex:0 0 auto; scroll-snap-align:start; display:flex; flex-direction:column; align-items:center; gap:0.35rem; padding:1rem 1.5rem; background:var(--bg); border:2px solid var(--border); border-radius:var(--radius); text-decoration:none; transition:all 0.2s; min-width:120px;" onmouseover="this.style.borderColor='var(--orange)'; this.style.background='#fff5eb';" onmouseout="this.style.borderColor='var(--border)'; this.style.background='var(--bg)';">
                @if($kat->gambar_path)
                <img src="{{ asset('storage/' . $kat->gambar_path) }}" alt="{{ $kat->nama_kategori }}" style="height:32px; width:auto; object-fit:contain; margin-bottom:0.25rem;">
                @else
                <span style="font-size:1.75rem; color:var(--navy);"><x-icon-car style="width:2rem;height:2rem;" /></span>
                @endif
                <span style="font-family:'Poppins',sans-serif; font-weight:600; font-size:0.875rem; color:var(--navy);">{{ $kat->nama_kategori }}</span>
                <span style="font-size:0.775rem; color:var(--text-muted);">{{ $kat->mobils_count }} unit</span>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- MEREK POPULER --}}
@if($merekPopuler->isNotEmpty())
<section style="padding:3rem 0; background:#f8fafc;">
    <div style="max-width:1280px; margin:0 auto; padding:0 1.25rem;">
        <h2 class="section-title" style="text-align:center; margin-bottom:2rem;">Jelajahi Berdasarkan Merek</h2>
        <div class="hide-scrollbar" style="display:flex; gap:1rem; overflow-x:auto; padding-bottom:1rem; scroll-snap-type:x mandatory;">
            @foreach($merekPopuler as $merek)
            <a href="{{ route('katalog', ['merek[]' => $merek->slug]) }}"
               style="flex:0 0 auto; scroll-snap-align:start; display:flex; flex-direction:column; align-items:center; gap:0.5rem; padding:1.25rem; background:#fff; border:2px solid var(--border); border-radius:var(--radius); font-family:'Poppins',sans-serif; font-weight:600; font-size:0.875rem; color:var(--navy); text-decoration:none; transition:all 0.2s; min-width:140px;"
               onmouseover="this.style.borderColor='var(--orange)'; this.style.color='var(--orange)'; this.style.boxShadow='0 4px 15px rgba(0,0,0,0.05)';"
               onmouseout="this.style.borderColor='var(--border)'; this.style.color='var(--navy)'; this.style.boxShadow='none';">
                @if($merek->logo_path)
                <img src="{{ asset('storage/' . $merek->logo_path) }}" alt="{{ $merek->nama_merek }}" style="height:40px; width:auto; object-fit:contain; margin-bottom:0.25rem;">
                @else
                <div style="height:40px; display:flex; align-items:center; justify-content:center; color:var(--text-muted);"><x-icon-car style="width:2rem;height:2rem;" /></div>
                @endif
                <div style="display:flex; align-items:center; gap:0.4rem;">
                    {{ $merek->nama_merek }}
                    <span style="background:var(--bg); color:var(--text-muted); border-radius:999px; padding:0.1rem 0.4rem; font-size:0.7rem; font-weight:500;">{{ $merek->mobils_count }}</span>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- UNIT UNGGULAN --}}
<section style="padding:4rem 0;">
    <div style="max-width:1280px; margin:0 auto; padding:0 1.25rem;">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:2rem; flex-wrap:wrap; gap:1rem;">
            <div>
                <h2 class="section-title">Unit Unggulan</h2>
                <p style="color:var(--text-muted); margin-top:0.5rem;">Pilihan terbaik yang kami rekomendasikan untuk Anda</p>
            </div>
            <a href="{{ route('katalog') }}" class="btn-outline btn-sm">Lihat Semua →</a>
        </div>

        <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(280px, 1fr)); gap:1.5rem;">
            @foreach($unitUnggulan as $mobil)
            @include('components.card-mobil', ['mobil' => $mobil])
            @endforeach

            @if($unitUnggulan->isEmpty())
            <div style="grid-column:1/-1; text-align:center; padding:3rem; color:var(--text-muted);">
                <p style="font-size:3rem; margin-bottom:0.5rem; color:#cbd5e1;"><x-icon-car style="width:4rem;height:4rem;margin:0 auto;" /></p>
                <p>Belum ada unit unggulan. <a href="{{ route('admin.mobil.index') }}">Tambahkan dari admin.</a></p>
            </div>
            @endif
        </div>
    </div>
</section>

{{-- UNIT BARU MASUK --}}
<section style="padding:4rem 0; background:#f8fafc;">
    <div style="max-width:1280px; margin:0 auto; padding:0 1.25rem;">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:2rem; flex-wrap:wrap; gap:1rem;">
            <div>
                <h2 class="section-title">Unit Baru Masuk</h2>
                <p style="color:var(--text-muted); margin-top:0.5rem;">Koleksi terbaru yang baru saja tiba di garasi kami</p>
            </div>
            <a href="{{ route('katalog') }}" class="btn-outline btn-sm">Lihat Semua →</a>
        </div>

        <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(280px, 1fr)); gap:1.5rem;">
            @foreach($unitTerbaru as $mobil)
            @include('components.card-mobil', ['mobil' => $mobil])
            @endforeach

            @if($unitTerbaru->isEmpty())
            <div style="grid-column:1/-1; text-align:center; padding:3rem; color:var(--text-muted);">
                <p style="font-size:3rem; margin-bottom:0.5rem; color:#cbd5e1;"><x-icon-car style="width:4rem;height:4rem;margin:0 auto;" /></p>
                <p>Belum ada unit terbaru.</p>
            </div>
            @endif
        </div>
    </div>
</section>


{{-- CTA BANNER --}}
<section style="padding:4rem 0; background:linear-gradient(135deg, var(--navy) 0%, var(--navy-light) 100%);">
    <div style="max-width:800px; margin:0 auto; padding:0 1.25rem; text-align:center;">
        <h2 style="color:#fff; font-size:clamp(1.75rem,4vw,2.5rem); font-family:'Poppins',sans-serif; font-weight:800; margin-bottom:1rem; display:flex; align-items:center; justify-content:center; gap:1rem;">
            Mau Test Drive Dulu? <x-icon-car style="width:2.5rem;height:2.5rem;" />
        </h2>
        <p style="color:rgba(255,255,255,0.8); font-size:1.05rem; margin-bottom:2rem; max-width:500px; margin-left:auto; margin-right:auto;">
            Jadwalkan test drive gratis sekarang dan rasakan langsung kenyamanan mobil pilihan Anda.
        </p>
        <div style="display:flex; gap:1rem; justify-content:center; flex-wrap:wrap;">
            <a href="{{ route('booking.create') }}" class="btn-primary" style="font-size:1rem; padding:0.875rem 2.5rem; display:flex; align-items:center; gap:0.5rem;"><x-lucide-calendar style="width:1.25rem;height:1.25rem;" /> Booking Test Drive Gratis</a>
            @php $wa = \App\Models\Setting::get('whatsapp_number'); @endphp
            @if($wa)
            <a href="https://wa.me/{{ $wa }}" target="_blank" class="btn-wa" style="font-size:1rem; padding:0.875rem 2rem; display:flex; align-items:center; gap:0.5rem;"><x-icon-wa style="width:1.25rem;height:1.25rem;" /> Chat WhatsApp</a>
            @endif
        </div>
    </div>
</section>

@endsection
