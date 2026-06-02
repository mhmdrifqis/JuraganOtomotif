@extends('layouts.admin')

@section('title', 'Manajemen Kategori')
@section('page_title', 'Manajemen Kategori')

@section('content')

<div class="admin-grid-layout">

    {{-- Tabel Kategori --}}
    <div class="card-base" style="overflow:hidden;">
        <div style="padding:1.25rem; border-bottom:1px solid var(--border);">
            <h3 style="font-family:'Poppins',sans-serif; font-weight:700; color:var(--navy); font-size:1rem; margin:0;">Daftar Kategori</h3>
        </div>
        <div style="overflow-x:auto;">
            <table class="table-admin">
                <thead>
                    <tr>
                        <th>Gambar</th>
                        <th>Nama Kategori</th>
                        <th>Jumlah Unit</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kategoris as $k)
                    <tr>
                        <td>
                            @if($k->gambar_path)
                            <img src="{{ asset('storage/'.$k->gambar_path) }}" alt="{{ $k->nama_kategori }}" style="height:32px; width:auto; object-fit:contain;">
                            @else
                            <span style="color:var(--text-muted); font-size:0.8rem;">-</span>
                            @endif
                        </td>
                        <td style="font-weight:600; color:var(--navy);">{{ $k->nama_kategori }}</td>
                        <td style="font-size:0.875rem; color:var(--text-muted);">{{ $k->mobils_count }} unit</td>
                        <td>
                            <div style="display:flex; gap:0.4rem;">
                                <button onclick="editKategori({{ $k->id }}, '{{ $k->nama_kategori }}')" class="btn-navy btn-sm">Edit</button>
                                @if($k->mobils_count == 0)
                                <form action="{{ route('admin.kategori.destroy', $k) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-outline btn-sm" style="color:#ef4444; border-color:#fca5a5;">Hapus</button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" style="text-align:center; padding:2rem; color:var(--text-muted);">Belum ada kategori.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($kategoris->hasPages())
        <div style="padding:1rem; border-top:1px solid var(--border);">
            {{ $kategoris->links() }}
        </div>
        @endif
    </div>

    {{-- Form Tambah/Edit --}}
    <div class="card-base" style="padding:1.5rem; position:sticky; top:80px;">
        <h3 id="form-title" style="font-family:'Poppins',sans-serif; font-weight:700; color:var(--navy); font-size:1rem; margin-bottom:1.25rem;">Tambah Kategori</h3>

        <form id="kategori-form" action="{{ route('admin.kategori.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="_method" id="form-method" value="POST">

            <div style="margin-bottom:1rem;">
                <label class="form-label">Nama Kategori <span style="color:#ef4444;">*</span></label>
                <input type="text" name="nama_kategori" id="nama_kategori" class="form-control" required placeholder="Contoh: SUV">
            </div>

            <div style="margin-bottom:1.25rem;">
                <label class="form-label">Gambar (Opsional)</label>
                <input type="file" name="gambar" class="form-control" accept="image/*" style="padding:0.5rem;">
                <p style="font-size:0.775rem; color:var(--text-muted); margin-top:0.3rem;">Format: JPG, PNG, WebP, SVG. Maks 2MB.</p>

                <div id="remove-gambar-wrapper" style="display:none; margin-top:0.5rem;">
                    <label style="display:flex; align-items:center; gap:0.5rem; cursor:pointer; font-size:0.875rem;">
                        <input type="checkbox" name="remove_gambar" value="1"> Hapus gambar saat ini
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
    const form = document.getElementById('kategori-form');
    const formTitle = document.getElementById('form-title');
    const formMethod = document.getElementById('form-method');
    const formSubmit = document.getElementById('form-submit');
    const formCancel = document.getElementById('form-cancel');
    const inputNama = document.getElementById('nama_kategori');
    const removeGambarWrapper = document.getElementById('remove-gambar-wrapper');

    function editKategori(id, nama) {
        formTitle.innerText = 'Edit Kategori';
        formMethod.value = 'PUT';
        form.action = '/admin/kategori/' + id;
        inputNama.value = nama;
        formSubmit.innerText = 'Simpan Perubahan';
        formCancel.style.display = 'flex';
        removeGambarWrapper.style.display = 'block';
    }

    function resetForm() {
        formTitle.innerText = 'Tambah Kategori';
        formMethod.value = 'POST';
        form.action = '{{ route("admin.kategori.store") }}';
        inputNama.value = '';
        formSubmit.innerText = 'Tambah';
        formCancel.style.display = 'none';
        removeGambarWrapper.style.display = 'none';
    }
</script>
@endpush
