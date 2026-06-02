<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Merek;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MerekController extends Controller
{
    public function index()
    {
        $mereks = Merek::withCount('mobils')->orderBy('nama_merek')->paginate(20);
        return view('admin.merek.index', compact('mereks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_merek' => 'required|string|max:255|unique:mereks',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,svg,webp|max:2048',
        ]);

        $data = [
            'nama_merek' => $request->nama_merek,
            'slug' => Str::slug($request->nama_merek),
        ];

        if ($request->hasFile('logo')) {
            $data['logo_path'] = $request->file('logo')->store('mereks', 'public');
        }

        Merek::create($data);

        return back()->with('success', 'Merek berhasil ditambahkan.');
    }

    public function update(Request $request, Merek $merek)
    {
        $request->validate([
            'nama_merek' => 'required|string|max:255|unique:mereks,nama_merek,' . $merek->id,
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,svg,webp|max:2048',
        ]);

        $data = [
            'nama_merek' => $request->nama_merek,
            'slug' => Str::slug($request->nama_merek),
        ];

        if ($request->hasFile('logo')) {
            if ($merek->logo_path && Storage::disk('public')->exists($merek->logo_path)) {
                Storage::disk('public')->delete($merek->logo_path);
            }
            $data['logo_path'] = $request->file('logo')->store('mereks', 'public');
        } elseif ($request->has('remove_logo')) {
             if ($merek->logo_path && Storage::disk('public')->exists($merek->logo_path)) {
                Storage::disk('public')->delete($merek->logo_path);
            }
            $data['logo_path'] = null;
        }

        $merek->update($data);

        return back()->with('success', 'Merek berhasil diperbarui.');
    }

    public function destroy(Merek $merek)
    {
        if ($merek->mobils()->count() > 0) {
            return back()->with('error', 'Merek tidak bisa dihapus karena masih digunakan oleh unit mobil.');
        }

        if ($merek->logo_path && Storage::disk('public')->exists($merek->logo_path)) {
            Storage::disk('public')->delete($merek->logo_path);
        }

        $merek->delete();

        return back()->with('success', 'Merek berhasil dihapus.');
    }
}
