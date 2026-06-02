<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class KategoriController extends Controller
{
    public function index()
    {
        $kategoris = Kategori::withCount('mobils')->orderBy('nama_kategori')->paginate(10);
        return view('admin.kategori.index', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategoris,nama_kategori',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
        ]);

        $data = [
            'nama_kategori' => $request->nama_kategori,
            'slug' => Str::slug($request->nama_kategori),
        ];

        if ($request->hasFile('gambar')) {
            $data['gambar_path'] = $request->file('gambar')->store('kategoris', 'public');
        }

        Kategori::create($data);

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function update(Request $request, Kategori $kategori)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategoris,nama_kategori,' . $kategori->id,
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
        ]);

        $data = [
            'nama_kategori' => $request->nama_kategori,
            'slug' => Str::slug($request->nama_kategori),
        ];

        if ($request->has('remove_gambar') && $request->remove_gambar == 1) {
            if ($kategori->gambar_path) Storage::disk('public')->delete($kategori->gambar_path);
            $data['gambar_path'] = null;
        }

        if ($request->hasFile('gambar')) {
            if ($kategori->gambar_path) Storage::disk('public')->delete($kategori->gambar_path);
            $data['gambar_path'] = $request->file('gambar')->store('kategoris', 'public');
        }

        $kategori->update($data);

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Kategori $kategori)
    {
        if ($kategori->mobils()->count() > 0) {
            return back()->with('error', 'Kategori tidak bisa dihapus karena masih memiliki unit mobil.');
        }

        if ($kategori->gambar_path) {
            Storage::disk('public')->delete($kategori->gambar_path);
        }

        $kategori->delete();

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
