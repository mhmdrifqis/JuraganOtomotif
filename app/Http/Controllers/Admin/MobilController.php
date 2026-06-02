<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mobil;
use App\Models\Merek;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\Storage;

class MobilController extends Controller
{
    public function index(Request $request)
    {
        $query = Mobil::withTrashed();

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('nama_mobil', 'like', "%{$request->search}%")
                  ->orWhereHas('merek', function($qm) use ($request) {
                      $qm->where('nama_merek', 'like', "%{$request->search}%");
                  });
            });
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $mobils = $query->latest()->paginate(15)->withQueryString();
        return view('admin.mobil.index', compact('mobils'));
    }

    public function create()
    {
        $mereks      = Merek::orderBy('nama_merek')->get();
        $kategoris   = Kategori::orderBy('nama_kategori')->get();
        $transmisis  = ['manual', 'matic'];
        $bahanBakars = ['bensin', 'diesel', 'hybrid', 'listrik'];
        $statuses    = ['tersedia', 'terjual', 'reservasi'];

        return view('admin.mobil.form', compact('mereks', 'kategoris', 'transmisis', 'bahanBakars', 'statuses'));
    }

    public function store(Request $request)
    {
        $data = $this->validateMobil($request);
        $data = $this->handleFotoUpload($request, $data);

        Mobil::create($data);
        return redirect()->route('admin.mobil.index')->with('success', 'Unit mobil berhasil ditambahkan!');
    }

    public function edit(Mobil $mobil)
    {
        $mereks      = Merek::orderBy('nama_merek')->get();
        $kategoris   = Kategori::orderBy('nama_kategori')->get();
        $transmisis  = ['manual', 'matic'];
        $bahanBakars = ['bensin', 'diesel', 'hybrid', 'listrik'];
        $statuses    = ['tersedia', 'terjual', 'reservasi'];

        return view('admin.mobil.form', compact('mobil', 'mereks', 'kategoris', 'transmisis', 'bahanBakars', 'statuses'));
    }

    public function update(Request $request, Mobil $mobil)
    {
        $data = $this->validateMobil($request, $mobil->id);
        $data = $this->handleFotoUpload($request, $data, $mobil);

        $mobil->update($data);
        return redirect()->route('admin.mobil.index')->with('success', 'Unit mobil berhasil diperbarui!');
    }

    public function destroy(Mobil $mobil)
    {
        $mobil->delete(); // soft delete
        return back()->with('success', 'Unit mobil berhasil diarsipkan.');
    }

    public function restore(int $id)
    {
        Mobil::withTrashed()->findOrFail($id)->restore();
        return back()->with('success', 'Unit mobil berhasil dipulihkan.');
    }

    public function duplicate(Mobil $mobil)
    {
        $new = $mobil->replicate();
        $new->slug   = Mobil::generateUniqueSlug($mobil->nama_mobil);
        $new->status = 'tersedia';
        $new->views_count = 0;
        $new->save();

        return redirect()->route('admin.mobil.edit', $new->id)->with('success', 'Unit berhasil diduplikasi. Silakan edit datanya.');
    }

    public function toggleFeatured(Mobil $mobil)
    {
        $mobil->update(['is_featured' => !$mobil->is_featured]);
        return back()->with('success', 'Status unggulan berhasil diubah.');
    }

    private function validateMobil(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'merek_id'        => 'required|exists:mereks,id',
            'kategori_id'     => 'required|exists:kategoris,id',
            'nama_mobil'      => 'required|string|max:150',
            'harga'           => 'required|integer|min:1',
            'bisa_nego'       => 'nullable|boolean',
            'kota'            => 'required|string|max:100',
            'tahun'           => 'required|integer|min:1990|max:' . (date('Y') + 1),
            'transmisi'       => 'required|in:manual,matic',
            'bahan_bakar'     => 'required|in:bensin,diesel,hybrid,listrik',
            'kapasitas_mesin' => 'required|integer|min:600|max:10000',
            'kilometer'       => 'required|integer|min:0',
            'warna'           => 'required|string|max:50',
            'deskripsi'       => 'nullable|string|max:2000',
            'status'          => 'required|in:tersedia,terjual,reservasi',
            'is_featured'     => 'nullable|boolean',
            'foto_utama'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'foto_galeri.*'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);
    }

    private function handleFotoUpload(Request $request, array $data, ?Mobil $mobil = null): array
    {
        $data['bisa_nego']   = $request->boolean('bisa_nego');
        $data['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('foto_utama')) {
            // Delete old
            if ($mobil?->foto_utama) {
                Storage::disk('public')->delete($mobil->foto_utama);
            }
            $path = $request->file('foto_utama')->store('mobil', 'public');
            $data['foto_utama'] = $path;
        }

        if ($request->hasFile('foto_galeri')) {
            $galeri = $mobil?->foto_galeri ?? [];
            foreach ($request->file('foto_galeri') as $file) {
                $path     = $file->store('mobil', 'public');
                $galeri[] = $path;
            }
            $data['foto_galeri'] = $galeri;
        }

        // Handle hapus foto galeri
        if ($request->filled('hapus_foto') && $mobil) {
            $hapus  = $request->input('hapus_foto', []);
            $galeri = array_values(array_filter(
                $mobil->foto_galeri ?? [],
                fn($p) => !in_array($p, $hapus)
            ));
            foreach ($hapus as $path) {
                Storage::disk('public')->delete($path);
            }
            $data['foto_galeri'] = $galeri;
        }

        return $data;
    }
}
