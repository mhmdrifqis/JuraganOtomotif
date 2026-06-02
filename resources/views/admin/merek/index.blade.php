@extends('layouts.admin')

@section('title', 'Manajemen Merek')
@section('page_title', 'Manajemen Merek')

@section('content')

<div class="admin-grid-layout">

    {{-- Tabel Merek --}}
    <div class="card-base" style="overflow:hidden;">
        <div style="padding:1.25rem; border-bottom:1px solid var(--border);">
            <h3 style="font-family:'Poppins',sans-serif; font-weight:700; color:var(--navy); font-size:1rem; margin:0;">Daftar Merek</h3>
        </div>
        <div style="overflow-x:auto;">
            <table class="table-admin">
                <thead>
                    <tr>
                        <th>Logo</th>
                        <th>Nama Merek</th>
                        <th>Jumlah Unit</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($mereks as $m)
                    <tr>
                        <td>
                            @if($m->logo_path)
                            <img src="{{ asset('storage/'.$m->logo_path) }}" alt="{{ $m->nama_merek }}" style="height:32px; width:auto; object-fit:contain;">
                            @else
                            <span style="color:var(--text-muted); font-size:0.8rem;">-</span>
                            @endif
                        </td>
                        <td style="font-weight:600; color:var(--navy);">{{ $m->nama_merek }}</td>
                        <td style="font-size:0.875rem; color:var(--text-muted);">{{ $m->mobils_count }} unit</td>
                        <td>
                            <div style="display:flex; gap:0.4rem;">
                                <button onclick="editMerek({{ $m->id }}, '{{ $m->nama_merek }}')" class="btn-navy btn-sm">Edit</button>
                                @if($m->mobils_count == 0)
                                <form action="{{ route('admin.merek.destroy', $m) }}" method="POST" onsubmit="return confirm('Hapus merek ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-outline btn-sm" style="color:#ef4444; border-color:#fca5a5;">Hapus</button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" style="text-align:center; padding:2rem; color:var(--text-muted);">Belum ada merek.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($mereks->hasPages())
        <div style="padding:1rem; border-top:1px solid var(--border);">
            {{ $mereks->links() }}
        </div>
        @endif
    </div>

    {{-- Form Tambah/Edit --}}
    <div class="card-base" style="padding:1.5rem; position:sticky; top:80px;">
        <h3 id="form-title" style="font-family:'Poppins',sans-serif; font-weight:700; color:var(--navy); font-size:1rem; margin-bottom:1.25rem;">Tambah Merek</h3>

        <form id="merek-form" action="{{ route('admin.merek.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="_method" id="form-method" value="POST">

            <div style="margin-bottom:1rem;">
                <label class="form-label">Nama Merek <span style="color:#ef4444;">*</span></label>
                <input type="text" name="nama_merek" id="nama_merek" class="form-control" required placeholder="Contoh: Toyota">
            </div>

            <div style="margin-bottom:1.25rem;">
                <label class="form-label">Logo (Opsional)</label>
                <input type="file" name="logo" class="form-control" accept="image/*" style="padding:0.5rem;">
                <p style="font-size:0.775rem; color:var(--text-muted); margin-top:0.3rem;">Format: JPG, PNG, WebP, SVG. Maks 2MB.</p>

                <div id="remove-logo-wrapper" style="display:none; margin-top:0.5rem;">
                    <label style="display:flex; align-items:center; gap:0.5rem; cursor:pointer; font-size:0.875rem;">
                        <input type="checkbox" name="remove_logo" value="1"> Hapus logo saat ini
                    </label>
                </div>
            </div>

            <div style="display:flex; flex-direction:column; gap:0.5rem;">
                <button type="submit" id="form-submit" class="btn-primary" style="width:100%; justify-content:center;">Tambah</button>
                <button type="button" id="form-cancel" class="btn-outline" style="width:100%; justify-content:center; display:none;" onclick="resetForm()">Batal Edit</button>
            </div>
        </form>
    </div>

</div>

@endsection

@push('scripts')
<script>
    const form = document.getElementById('merek-form');
    const formTitle = document.getElementById('form-title');
    const formMethod = document.getElementById('form-method');
    const formSubmit = document.getElementById('form-submit');
    const formCancel = document.getElementById('form-cancel');
    const inputNama = document.getElementById('nama_merek');
    const removeLogoWrapper = document.getElementById('remove-logo-wrapper');

    function editMerek(id, nama) {
        formTitle.innerText = 'Edit Merek';
        formMethod.value = 'PUT';
        form.action = '/admin/merek/' + id;
        inputNama.value = nama;
        formSubmit.innerText = 'Simpan Perubahan';
        formCancel.style.display = 'flex';
        removeLogoWrapper.style.display = 'block';
    }

    function resetForm() {
        formTitle.innerText = 'Tambah Merek';
        formMethod.value = 'POST';
        form.action = '{{ route("admin.merek.store") }}';
        inputNama.value = '';
        formSubmit.innerText = 'Tambah';
        formCancel.style.display = 'none';
        removeLogoWrapper.style.display = 'none';
    }
</script>
@endpush
