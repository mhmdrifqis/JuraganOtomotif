<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::$defaults;
        // Load saved values
        foreach (array_keys($settings) as $key) {
            $settings[$key] = Setting::get($key);
        }

        return view('admin.settings', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'logo'             => 'nullable|image|mimes:jpeg,png,jpg,svg,webp|max:2048',
            'whatsapp_number'  => 'required|regex:/^62[0-9]{8,13}$/',
            'whatsapp_message' => 'required|string|max:500',
            'instagram_url'    => 'nullable|url',
            'tiktok_url'       => 'nullable|url',
            'hero_title'       => 'required|string|max:100',
            'hero_subtitle'    => 'required|string|max:200',
            'alamat'           => 'nullable|string|max:300',
            'jam_operasional'  => 'nullable|string|max:100',
            'meta_title_home'  => 'nullable|string|max:70',
            'meta_desc_home'   => 'nullable|string|max:160',
        ], [
            'whatsapp_number.regex' => 'Format nomor WA harus diawali 62 (tanpa +), contoh: 6281234567890',
        ]);

        $data = $request->only(array_keys(Setting::$defaults));

        if ($request->hasFile('logo')) {
            $oldLogo = Setting::get('logo_path');
            if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
                Storage::disk('public')->delete($oldLogo);
            }
            $data['logo_path'] = $request->file('logo')->store('settings', 'public');
        }

        Setting::setMany($data);

        return back()->with('success', 'Pengaturan berhasil disimpan!');
    }
}
