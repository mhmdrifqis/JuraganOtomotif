@extends('layouts.app')
@section('title', 'Profil Saya')
@section('content')
    <div style="max-width:1280px; margin:0 auto; padding:2rem 1.25rem;">
        <h1 class="section-title" style="margin-bottom:0.5rem; display:flex; align-items:center; gap:0.5rem;"><x-lucide-user style="width:2rem;height:2rem;" /> Profil Saya</h1>
        <p style="color:var(--text-muted); margin-bottom:2rem;">Kelola informasi profil, alamat email, dan kata sandi akun Anda.</p>

        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(380px, 1fr)); gap:2rem;">
            <div style="background:#fff; border-radius:1rem; padding:2rem; box-shadow:0 10px 40px rgba(0,0,0,0.05); border:1px solid #f1f5f9;">
                @include('profile.partials.update-profile-information-form')
            </div>

            <div style="background:#fff; border-radius:1rem; padding:2rem; box-shadow:0 10px 40px rgba(0,0,0,0.05); border:1px solid #f1f5f9;">
                @include('profile.partials.update-password-form')
            </div>

            <div style="background:#fff; border-radius:1rem; padding:2rem; box-shadow:0 10px 40px rgba(0,0,0,0.05); border:1px solid #f1f5f9;">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
@endsection
