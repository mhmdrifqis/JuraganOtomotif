<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Mobil;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BookingController extends Controller
{
    public function create(Request $request)
    {
        $mobilId   = $request->query('mobil_id');
        $mobilItem = $mobilId ? Mobil::find($mobilId) : null;
        $mobils    = Mobil::tersedia()->orderBy('nama_mobil')->get();
        $slots     = Booking::$slotJam;

        return view('pages.booking', compact('mobilItem', 'mobils', 'slots'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pembeli'      => 'required|string|min:3|max:100',
            'no_hp'             => ['required', 'regex:/^(08|62)[0-9]{7,12}$/'],
            'mobil_id'          => 'required|exists:mobil,id',
            'tanggal_test_drive'=> 'required|date|after_or_equal:today',
            'jam_preferred'     => ['required', Rule::in(array_keys(Booking::$slotJam))],
            'catatan'           => 'nullable|string|max:500',
        ], [
            'no_hp.regex'       => 'Format nomor HP tidak valid. Gunakan format 08xx atau 62xx.',
            'tanggal_test_drive.after_or_equal' => 'Tanggal test drive tidak boleh di masa lalu.',
        ]);

        $booking = Booking::create([
            'mobil_id'          => $request->mobil_id,
            'nama_pembeli'      => $request->nama_pembeli,
            'no_hp'             => $request->no_hp,
            'tanggal_test_drive'=> $request->tanggal_test_drive,
            'jam_preferred'     => $request->jam_preferred,
            'catatan'           => $request->catatan,
            'status'            => 'pending',
        ]);

        // Generate WA notification link for admin
        $mobil     = Mobil::find($request->mobil_id);
        $waNumber  = Setting::get('whatsapp_number');
        $pesan     = "⚡ *Booking Test Drive Baru!*\n\n"
                   . "🚗 Unit: {$mobil->nama_mobil} {$mobil->tahun}\n"
                   . "👤 Nama: {$booking->nama_pembeli}\n"
                   . "📱 HP: {$booking->no_hp}\n"
                   . "📅 Tanggal: {$booking->tanggal_test_drive->format('d/m/Y')}\n"
                   . "⏰ Jam: " . Booking::$slotJam[$booking->jam_preferred] . "\n"
                   . "📝 Catatan: " . ($booking->catatan ?: '-') . "\n\n"
                   . "Silakan konfirmasi via dashboard admin.";

        $waLink = "https://wa.me/{$waNumber}?text=" . urlencode($pesan);

        return redirect()->route('booking.sukses', $booking->id)->with('wa_link', $waLink);
    }

    public function sukses(Booking $booking)
    {
        return view('pages.booking-sukses', compact('booking'));
    }

    public function history()
    {
        $user = auth()->user();
        
        $bookings = Booking::where(function($query) use ($user) {
            if ($user->phone) {
                // Hapus awalan 0, 62, atau +62 untuk perbandingan fleksibel
                $phoneStr = preg_replace('/^(?:\+62|62|0)/', '', $user->phone);
                $query->where('no_hp', 'LIKE', '%' . $phoneStr);
            }
            // Juga cocokkan berdasarkan nama (sebagai antisipasi)
            $query->orWhere('nama_pembeli', $user->name);
        })
        ->with('mobil')
        ->orderBy('created_at', 'desc')
        ->get();

        return view('pages.booking-history', compact('bookings'));
    }
}
