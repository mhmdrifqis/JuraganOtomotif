<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with('mobil');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('tanggal_dari')) {
            $query->whereDate('tanggal_test_drive', '>=', $request->tanggal_dari);
        }
        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('tanggal_test_drive', '<=', $request->tanggal_sampai);
        }
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_pembeli', 'like', "%{$request->search}%")
                  ->orWhere('no_hp', 'like', "%{$request->search}%");
            });
        }

        $bookings   = $query->latest()->paginate(15)->withQueryString();
        $statusList = Booking::$statusLabel;

        return view('admin.booking.index', compact('bookings', 'statusList'));
    }

    public function update(Request $request, Booking $booking)
    {
        $request->validate([
            'status'        => 'required|in:pending,dikonfirmasi,selesai,dibatalkan',
            'catatan_admin' => 'nullable|string|max:500',
        ]);

        $booking->update([
            'status'        => $request->status,
            'catatan_admin' => $request->catatan_admin,
        ]);

        if ($booking->mobil) {
            if ($request->status === 'dikonfirmasi') {
                $booking->mobil->update(['status' => 'direservasi']);
            } elseif ($request->status === 'dibatalkan') {
                $booking->mobil->update(['status' => 'tersedia']);
            } elseif ($request->status === 'selesai') {
                $booking->mobil->update(['status' => 'terjual']);
            }
        }

        return back()->with('success', "Status booking #{$booking->id} berhasil diperbarui.");
    }

    public function export(Request $request)
    {
        $query = Booking::with('mobil');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $bookings = $query->latest()->get();

        $csv  = "ID,Nama Pembeli,No HP,Unit,Tahun,Tanggal Test Drive,Jam,Status,Catatan,Catatan Admin,Dibuat\n";
        foreach ($bookings as $b) {
            $csv .= implode(',', [
                $b->id,
                '"' . $b->nama_pembeli . '"',
                $b->no_hp,
                '"' . ($b->mobil->nama_mobil ?? '-') . '"',
                $b->mobil->tahun ?? '-',
                $b->tanggal_test_drive->format('d/m/Y'),
                Booking::$slotJam[$b->jam_preferred] ?? $b->jam_preferred,
                Booking::$statusLabel[$b->status] ?? $b->status,
                '"' . ($b->catatan ?? '') . '"',
                '"' . ($b->catatan_admin ?? '') . '"',
                $b->created_at->format('d/m/Y H:i'),
            ]) . "\n";
        }

        return response($csv, 200, [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="bookings-' . now()->format('Ymd') . '.csv"',
        ]);
    }
}
