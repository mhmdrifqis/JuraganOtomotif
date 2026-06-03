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
                $booking->mobil->update(['status' => 'reservasi']);
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

        $html  = '<table border="1">';
        $html .= '<thead><tr>';
        $html .= '<th>ID</th><th>Nama Pembeli</th><th>No HP</th><th>Unit</th><th>Tahun</th>';
        $html .= '<th>Tanggal Test Drive</th><th>Jam</th><th>Status</th><th>Catatan</th>';
        $html .= '<th>Catatan Admin</th><th>Dibuat</th>';
        $html .= '</tr></thead><tbody>';

        foreach ($bookings as $b) {
            $html .= '<tr>';
            $html .= '<td>' . $b->id . '</td>';
            $html .= '<td>' . htmlspecialchars($b->nama_pembeli) . '</td>';
            $html .= '<td>="' . htmlspecialchars($b->no_hp) . '"</td>'; // prevent scientific notation
            $html .= '<td>' . htmlspecialchars($b->mobil->nama_mobil ?? '-') . '</td>';
            $html .= '<td>' . ($b->mobil->tahun ?? '-') . '</td>';
            $html .= '<td>' . $b->tanggal_test_drive->format('d/m/Y') . '</td>';
            $html .= '<td>' . (Booking::$slotJam[$b->jam_preferred] ?? $b->jam_preferred) . '</td>';
            $html .= '<td>' . (Booking::$statusLabel[$b->status] ?? $b->status) . '</td>';
            $html .= '<td>' . htmlspecialchars($b->catatan ?? '') . '</td>';
            $html .= '<td>' . htmlspecialchars($b->catatan_admin ?? '') . '</td>';
            $html .= '<td>' . $b->created_at->format('d/m/Y H:i') . '</td>';
            $html .= '</tr>';
        }
        $html .= '</tbody></table>';

        return response($html, 200, [
            'Content-Type'        => 'application/vnd.ms-excel',
            'Content-Disposition' => 'attachment; filename="bookings-' . now()->format('Ymd') . '.xls"',
        ]);
    }
}
