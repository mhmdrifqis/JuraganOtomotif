<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'mobil_id', 'nama_pembeli', 'no_hp',
        'tanggal_test_drive', 'jam_preferred',
        'catatan', 'status', 'catatan_admin',
    ];

    protected $casts = [
        'tanggal_test_drive' => 'date',
    ];

    public static array $slotJam = [
        '09:00:00' => '09.00 WIB',
        '11:00:00' => '11.00 WIB',
        '13:00:00' => '13.00 WIB',
        '15:00:00' => '15.00 WIB',
        '17:00:00' => '17.00 WIB',
    ];

    public static array $statusLabel = [
        'pending'      => 'Menunggu',
        'dikonfirmasi' => 'Dikonfirmasi',
        'selesai'      => 'Selesai',
        'dibatalkan'   => 'Dibatalkan',
    ];

    public static array $statusColor = [
        'pending'      => 'yellow',
        'dikonfirmasi' => 'blue',
        'selesai'      => 'green',
        'dibatalkan'   => 'red',
    ];

    public function mobil()
    {
        return $this->belongsTo(Mobil::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return self::$statusLabel[$this->status] ?? $this->status;
    }

    // Generate WhatsApp deep link to notify buyer of confirmation
    public function getWaLinkPembeliAttribute(): string
    {
        $no = preg_replace('/^0/', '62', $this->no_hp);
        $no = preg_replace('/[^0-9]/', '', $no);
        $nama   = $this->mobil->nama_mobil ?? '';
        $tahun  = $this->mobil->tahun ?? '';
        $tgl    = $this->tanggal_test_drive->translatedFormat('d F Y');
        $jam    = self::$slotJam[$this->jam_preferred] ?? $this->jam_preferred;
        $pesan  = urlencode("Halo {$this->nama_pembeli}, booking test drive {$nama} {$tahun} Anda pada {$tgl} pukul {$jam} telah *{$this->status_label}*. Terima kasih! - Juragan Otomotif");
        return "https://wa.me/{$no}?text={$pesan}";
    }
}
