<table>
<colgroup>
<col style="width: 100%" />
</colgroup>
<tbody>
<tr>
<td style="text-align: center;"><p><strong>JURAGAN OTOMOTIF</strong></p>
<p>――――――――――――</p>
<p>Product Requirements Document (PRD)</p>
<p>Platform E-Commerce Jual Beli Mobil Bekas</p></td>
</tr>
</tbody>
</table>

| **Atribut**     | **Detail**                       |
|-----------------|----------------------------------|
| Versi Dokumen   | 1.0                              |
| Tanggal Dibuat  | Mei 2025                         |
| Status          | Draft -- Untuk Review            |
| Platform        | Web (Mobile-Friendly)            |
| Tipe Bisnis     | Platform Pribadi (Single Seller) |
| Kategori Produk | Mobil Bekas (Used Car)           |

> **1. RINGKASAN EKSEKUTIF**

**1.1 Latar Belakang**

Juragan Otomotif adalah platform digital milik pribadi yang dirancang untuk memudahkan proses jual beli mobil bekas secara langsung antara pemilik usaha (owner/admin) dengan calon pembeli. Platform ini berfungsi sebagai katalog digital interaktif sehingga calon pembeli dapat melihat informasi lengkap unit mobil yang tersedia, melakukan perbandingan, hingga menghubungi penjual secara langsung -- tanpa perlu datang ke showroom terlebih dahulu.

**1.2 Tujuan Produk**

- Menampilkan katalog mobil bekas yang tersedia secara real-time dan informatif

- Mempermudah calon pembeli dalam mencari, menyaring, dan membandingkan unit mobil

- Menyediakan saluran komunikasi langsung antara buyer dan owner via WhatsApp

- Menyediakan fitur Test Drive Booking untuk meningkatkan konversi

- Membangun kredibilitas dan kepercayaan melalui tampilan profesional

- Terintegrasi dengan media sosial (TikTok / Instagram) untuk mendatangkan traffic

**1.3 Ruang Lingkup**

|  |  |
|----|----|
| **IN SCOPE** | Katalog mobil bekas, fitur pencarian & filter, perbandingan mobil, test drive booking, integrasi WhatsApp, integrasi media sosial, dashboard admin untuk manajemen listing. |

|  |  |
|----|----|
| **OUT OF SCOPE** | Multi-seller marketplace, sistem pembayaran online (Midtrans/Xendit), fitur cicilan/DP, fitur lelang/bidding, aplikasi mobile native (iOS/Android). |

> **2. PENGGUNA & PERSONA**

**2.1 Jenis Pengguna**

| **Role** | **Deskripsi** | **Akses Utama** |
|----|----|----|
| Pembeli (Buyer) | Pengunjung yang ingin mencari dan membeli mobil bekas | Katalog, Filter, Perbandingan, Booking, WhatsApp |
| Admin / Owner | Pemilik platform yang mengelola seluruh listing dan operasional | Dashboard Admin, CRUD Listing, Manajemen Booking, Laporan |

**2.2 Persona Pembeli**

**Persona 1: Budi -- Karyawan Swasta (28 thn)**

- Butuh mobil keluarga bekas dengan budget terbatas

- Sering browsing via smartphone di waktu senggang

- Ingin lihat spesifikasi lengkap sebelum menghubungi penjual

- Pain point: susah membandingkan spesifikasi antar unit

**Persona 2: Sari -- Ibu Rumah Tangga (35 thn)**

- Mencari mobil city car untuk keperluan sehari-hari

- Menemukan listing dari Instagram/TikTok

- Ingin booking test drive sebelum memutuskan beli

- Pain point: tidak percaya foto yang tidak informatif

> **3. FITUR & PERSYARATAN FUNGSIONAL**

**3.1 Katalog Mobil**

Halaman utama menampilkan grid/list unit mobil yang tersedia. Setiap kartu listing menampilkan informasi ringkas yang memudahkan calon pembeli dalam memilah unit.

**3.1.1 Data yang Ditampilkan per Unit**

| **Field** | **Tipe Data** | **Wajib** | **Keterangan** |
|----|----|----|----|
| Foto (multiple) | Image Gallery | Ya | Min. 5 foto, mendukung lightbox viewer |
| Merek | Text / Dropdown | Ya | Toyota, Honda, Suzuki, dll. |
| Kategori | Text / Dropdown | Ya | SUV, MPV, Sedan, Hatchback, Pickup |
| Nama Mobil / Tipe | Text | Ya | Contoh: Avanza 1.3 G MT |
| Harga | Currency (IDR) | Ya | Format Rupiah, bisa nego toggle |
| Kota / Lokasi | Text | Ya | Contoh: Jakarta Selatan |
| Tahun | Integer | Ya | Tahun produksi |
| Transmisi | Dropdown | Ya | Manual / Matic |
| Bahan Bakar | Dropdown | Ya | Bensin / Diesel / Hybrid / Listrik |
| Kapasitas Mesin (CC) | Integer | Ya | Contoh: 1300, 1500, 2000 |
| Kilometer (KM) | Integer | Ya | Odometer terakhir |
| Warna | Text / Color Picker | Ya | Warna eksterior kendaraan |
| Deskripsi Tambahan | Textarea | Tidak | Catatan kondisi, kelengkapan surat |
| Status Unit | Badge | Ya | Tersedia / Terjual / Reservasi |

**3.2 Pencarian & Filter**

**3.2.1 Search Bar**

- Pencarian berdasarkan nama mobil, merek, atau tipe

- Auto-complete / suggestion saat mengetik

- Pencarian tidak case-sensitive

**3.2.2 Filter Panel**

| **Filter**  | **Tipe Input**            | **Nilai Contoh**                  |
|-------------|---------------------------|-----------------------------------|
| Merek       | Multi-select checkbox     | Toyota, Honda, Suzuki, Mitsubishi |
| Kategori    | Multi-select checkbox     | SUV, MPV, Sedan, Hatchback        |
| Harga       | Range slider (min-max)    | Rp 50.000.000 -- Rp 500.000.000   |
| Tahun       | Range slider (min-max)    | 2010 -- 2024                      |
| Transmisi   | Radio button              | Semua / Manual / Matic            |
| Bahan Bakar | Multi-select checkbox     | Bensin / Diesel / Hybrid          |
| Kota        | Dropdown                  | Jakarta, Bandung, Surabaya, dll.  |
| Warna       | Color swatch multi-select | Putih, Hitam, Silver, Merah       |

**3.3 Halaman Detail Mobil**

- Gallery foto fullscreen dengan navigasi kiri/kanan dan thumbnail strip

- Semua data unit ditampilkan lengkap (lihat Tabel 3.1.1)

- Tombol CTA utama: Hubungi via WhatsApp (floating button)

- Tombol CTA sekunder: Booking Test Drive

- Tombol: Tambahkan ke Perbandingan

- Share ke media sosial (Instagram, TikTok, WhatsApp)

- Badge status unit yang jelas (Tersedia / Terjual / Reservasi)

**3.4 Fitur Perbandingan Mobil**

Pembeli dapat memilih 2--3 unit mobil untuk dibandingkan secara side-by-side.

- Tombol \'Bandingkan\' tersedia di kartu listing dan halaman detail

- Maksimal 3 unit dapat dibandingkan sekaligus

- Tabel perbandingan menampilkan semua field (harga, tahun, KM, CC, transmisi, dll.)

- Highlight otomatis nilai terbaik di setiap baris (harga terendah, KM terendah, tahun terbaru)

- Tombol CTA di bawah setiap kolom: Hubungi / Booking

**3.5 Test Drive Booking**

Fitur ini memungkinkan calon pembeli menjadwalkan test drive tanpa harus menghubungi penjual secara manual terlebih dahulu.

**3.5.1 Alur Booking**

1.  Pembeli klik tombol \'Booking Test Drive\' di halaman detail unit

2.  Isi formulir: Nama, No. HP, Tanggal, Jam, Catatan (opsional)

3.  Submit → sistem kirim notifikasi ke Admin (email/WhatsApp)

4.  Sistem kirim konfirmasi otomatis ke pembeli (via WhatsApp link)

5.  Admin konfirmasi atau reschedule via dashboard

**3.5.2 Data Formulir Booking**

| **Field** | **Wajib** | **Validasi** |
|----|----|----|
| Nama Lengkap | Ya | Min. 3 karakter |
| Nomor HP / WhatsApp | Ya | Format nomor Indonesia (08xx / 62xx) |
| Unit yang Diminati | Ya | Auto-fill dari halaman detail unit |
| Tanggal Test Drive | Ya | Tidak boleh tanggal lampau, hari kerja saja |
| Jam Preferred | Ya | Pilihan slot: 09.00, 11.00, 13.00, 15.00, 17.00 |
| Catatan Tambahan | Tidak | Textarea bebas, maks. 500 karakter |

**3.6 Integrasi WhatsApp**

- Tombol WhatsApp floating di setiap halaman (bottom-right)

- Deep link ke WhatsApp dengan pesan template otomatis berisi nama unit & URL halaman

- Template pesan: \"Halo Juragan Otomotif, saya tertarik dengan \[Nama Mobil\] \[Tahun\]. Bisa info lebih lanjut?\"

- Nomor WhatsApp dikonfigurasi oleh Admin

**3.7 Integrasi Media Sosial**

| **Platform** | **Fitur Integrasi** |
|----|----|
| Instagram | Feed embed di homepage, tombol follow, link ke profil |
| TikTok | Embed video TikTok di halaman detail unit atau homepage |
| WhatsApp | Share button di setiap listing, deep link chat |
| General Share | Open Graph tags untuk preview yang menarik saat link di-share |

> **4. DASHBOARD ADMIN**

**4.1 Manajemen Listing Mobil**

- Tambah unit baru (form lengkap sesuai field di Tabel 3.1.1)

- Edit data unit yang sudah ada

- Hapus / Arsipkan unit (soft delete)

- Upload multiple foto dengan drag-and-drop, auto-resize, dan watermark opsional

- Ubah status unit: Tersedia / Terjual / Reservasi

- Fitur duplikasi unit (untuk unit yang mirip)

**4.2 Manajemen Booking Test Drive**

- Lihat semua booking yang masuk (tabel dengan filter tanggal, status)

- Status booking: Pending / Dikonfirmasi / Selesai / Dibatalkan

- Ubah status booking dengan notifikasi otomatis ke pembeli

- Catatan internal admin per booking

- Ekspor data booking ke CSV/Excel

**4.3 Pengaturan Platform**

- Konfigurasi nomor WhatsApp aktif

- Pengaturan jam operasional (untuk slot booking)

- Manajemen konten homepage (banner, teks promosi)

- Konfigurasi link media sosial (Instagram, TikTok)

- SEO Settings: Meta title, meta description per halaman

**4.4 Analitik Dasar**

- Jumlah pengunjung harian/bulanan

- Unit paling banyak dilihat

- Jumlah booking per bulan

- Sumber traffic (Google, Instagram, TikTok, WhatsApp)

> **5. PERSYARATAN DESAIN & UX**

**5.1 Prinsip Desain**

| **Prinsip** | **Implementasi** |
|----|----|
| Mobile-First | Layout responsif 320px -- 1440px; prioritas tampilan smartphone |
| Kecepatan Loading | Lazy loading gambar, kompresi foto otomatis, target \< 3 detik |
| Kepercayaan (Trust) | Foto berkualitas, informasi lengkap, badge verifikasi unit |
| Call to Action Jelas | Tombol WhatsApp & Booking selalu visible, warna kontras tinggi |
| Kemudahan Navigasi | Filter intuitif, breadcrumb, back-to-top button |

**5.2 Identitas Visual**

|                |                  |
|----------------|------------------|
| **Nama Brand** | Juragan Otomotif |

|                 |                                                 |
|-----------------|-------------------------------------------------|
| **Warna Utama** | Navy Blue (#1E3A5F) -- profesional & terpercaya |

|                 |                                                |
|-----------------|------------------------------------------------|
| **Warna Aksen** | Oranye (#E8821A) -- energik, CTA yang mencolok |

|               |                                                   |
|---------------|---------------------------------------------------|
| **Tipografi** | Inter / Poppins -- modern, mudah dibaca di mobile |

|  |  |
|----|----|
| **Tone of Voice** | Profesional namun ramah; bahasa Indonesia yang jelas dan lugas |

**5.3 Sitemap**

| **Halaman** | **URL** | **Deskripsi** |
|----|----|----|
| Beranda | / | Hero banner, unit unggulan, kategori cepat, feed sosmed |
| Katalog | /katalog | Grid listing semua unit dengan filter & search |
| Detail Unit | /mobil/\[slug\] | Info lengkap 1 unit, foto gallery, tombol CTA |
| Perbandingan | /bandingkan | Side-by-side max 3 unit |
| Booking Test Drive | /booking | Formulir jadwal test drive |
| Tentang Kami | /tentang | Profil usaha, alamat, peta |
| Kontak | /kontak | Nomor WA, email, media sosial |
| Admin Login | /admin/login | Halaman masuk admin |
| Admin Dashboard | /admin/dashboard | Panel manajemen listing & booking |

> **6. PERSYARATAN TEKNIS**

**6.1 Stack Teknologi (Rekomendasi)**

| **Layer** | **Teknologi** | **Alasan** |
|----|----|----|
| Frontend | Next.js + Tailwind CSS | SSR untuk SEO optimal, mobile-first styling |
| Backend | Next.js API Routes / Node.js | Terintegrasi dalam satu codebase |
| Database | PostgreSQL / MySQL | Relasional, cocok untuk listing & booking |
| ORM | Prisma | Type-safe, mudah migrate |
| Storage Foto | Cloudinary / S3 | CDN global, auto-resize & watermark |
| Auth Admin | NextAuth.js | Simple session management |
| Hosting | Vercel / VPS | Deploy mudah, auto-scaling |
| Analytics | Google Analytics 4 | Tracking pengunjung & konversi |

**6.2 SEO & Performa**

- Server-Side Rendering (SSR) untuk semua halaman listing

- Open Graph & Twitter Card meta tags untuk setiap unit

- Sitemap XML otomatis

- Google Search Console integration

- Core Web Vitals target: LCP \< 2.5s, FID \< 100ms, CLS \< 0.1

- Gambar menggunakan format WebP dengan fallback JPG

**6.3 Keamanan**

- HTTPS wajib (SSL certificate)

- Autentikasi admin dengan JWT + session expiry

- Rate limiting pada form booking untuk mencegah spam

- Input sanitization untuk mencegah SQL injection & XSS

- CAPTCHA pada form booking (Google reCAPTCHA v3)

- Backup database otomatis harian

> **7. PRIORITAS & ROADMAP**

**7.1 MoSCoW Prioritization**

| **Prioritas**            | **Fitur**                             |
|--------------------------|---------------------------------------|
| MUST HAVE ✓              | Katalog listing mobil lengkap         |
| MUST HAVE ✓              | Pencarian & filter multi-kriteria     |
| MUST HAVE ✓              | Halaman detail unit + foto gallery    |
| MUST HAVE ✓              | Tombol WhatsApp (floating + CTA)      |
| MUST HAVE ✓              | Dashboard admin CRUD listing          |
| MUST HAVE ✓              | Mobile-responsive design              |
| SHOULD HAVE ▷            | Test Drive Booking                    |
| SHOULD HAVE ▷            | Fitur Perbandingan Mobil              |
| SHOULD HAVE ▷            | Manajemen booking di admin            |
| COULD HAVE ◇             | Integrasi feed Instagram / TikTok     |
| COULD HAVE ◇             | Analitik dasar (views, booking count) |
| COULD HAVE ◇             | Notifikasi booking via WhatsApp API   |
| WON\'T HAVE (fase ini) ✕ | Payment gateway (Midtrans/Xendit)     |
| WON\'T HAVE (fase ini) ✕ | Multi-seller / marketplace            |
| WON\'T HAVE (fase ini) ✕ | Fitur cicilan / DP online             |

**7.2 Fase Pengembangan**

| **Fase** | **Durasi** | **Deliverable** |
|----|----|----|
| Fase 1: MVP | 4--6 minggu | Katalog, Detail, Search/Filter, WhatsApp, Admin CRUD |
| Fase 2: Engagement | 3--4 minggu | Perbandingan Mobil, Booking Test Drive, Admin Booking |
| Fase 3: Growth | 2--3 minggu | Integrasi Sosmed, Analitik, SEO Optimization, Speed |

> **8. METRIK KEBERHASILAN (KPI)**

| **Metrik** | **Target (3 Bulan Pertama)** | **Cara Ukur** |
|----|----|----|
| Pengunjung Unik / Bulan | \> 500 pengunjung | Google Analytics |
| Durasi Rata-rata di Site | \> 2 menit | Google Analytics |
| Bounce Rate | \< 60% | Google Analytics |
| Jumlah Booking Test Drive | \> 10 booking/bulan | Dashboard Admin |
| Click WhatsApp (kontak) | \> 30 klik/bulan | GA Event Tracking |
| Halaman Load Time | \< 3 detik | PageSpeed Insights |
| Mobile Usability Score | \> 90 / 100 | Google Search Console |
| Unit Terjual via Platform | \> 3 unit/bulan | Tracking manual owner |

> **9. ASUMSI & RISIKO**

**9.1 Asumsi**

- Owner/Admin memiliki akses smartphone dan komputer untuk mengelola platform

- Foto unit mobil akan disediakan oleh owner dengan kualitas yang cukup

- Nomor WhatsApp yang digunakan aktif dan dimonitor secara reguler

- Koneksi internet calon pembeli cukup untuk loading foto (min. 4G)

**9.2 Risiko & Mitigasi**

| **Risiko** | **Dampak** | **Mitigasi** |
|----|----|----|
| Foto unit berkualitas rendah | Tinggi -- menurunkan kepercayaan | Panduan foto, minimum 5 foto per unit, outdoor natural light |
| Admin tidak update status unit terjual | Tinggi -- buyer kecewa | SOP update status, notifikasi reminder ke admin |
| Spam booking palsu | Medium -- membuang waktu admin | CAPTCHA, validasi nomor HP, konfirmasi dua arah |
| Loading lambat karena foto banyak | Medium -- pengunjung kabur | Cloudinary CDN, lazy loading, WebP format |
| Traffic rendah di awal | Medium -- ROI lambat | Konsisten posting konten di TikTok/Instagram |

> **10. GLOSARIUM**

| **Istilah** | **Definisi** |
|----|----|
| PRD | Product Requirements Document -- dokumen spesifikasi kebutuhan produk |
| MVP | Minimum Viable Product -- versi minimal produk yang sudah bisa digunakan |
| CTA | Call to Action -- tombol/ajakan untuk melakukan tindakan tertentu |
| Deep Link | URL yang langsung membuka aplikasi WhatsApp dengan pesan terisi otomatis |
| SSR | Server-Side Rendering -- halaman di-render di server untuk SEO optimal |
| Slug | URL-friendly versi nama unit, contoh: toyota-avanza-2020-putih |
| CDN | Content Delivery Network -- jaringan server untuk distribusi file cepat |
| KPI | Key Performance Indicator -- indikator pengukur keberhasilan |
| Soft Delete | Menghapus data secara logis (tersembunyi) tanpa menghapus dari database |

<table>
<colgroup>
<col style="width: 100%" />
</colgroup>
<tbody>
<tr>
<td style="text-align: center;"><p><strong>Juragan Otomotif – Solusi Cerdas Jual Beli Mobil Bekas</strong></p>
<p>Dokumen ini bersifat konfidensial dan hanya untuk penggunaan internal.</p></td>
</tr>
</tbody>
</table>
