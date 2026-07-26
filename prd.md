Nama Sistem: Sistem Ranting Siaga Sehat Jiwa (Pendataan Warga Ranting 'Aisyiyah DIY)
Versi: 1.0
Target Pengguna: ~15.000 Akun Admin (Non-serentak), 3 Juta Baris Data Pendataan
Tech Stack: Laravel 12, Alpine.js, Tailwind CSS, MySQL, Redis (Caching)

1. STRATEGI PENGEMBANGAN & OPTIMASI (SANGAT PENTING UNTUK AGENT)
Mengingat skala data mencapai 3 juta records, Agent DIWAJIBKAN mengimplementasikan standar berikut saat melakukan generate kode:

Database Indexing: Kolom yang sering dicari (nik, nama, id_ranting, status_kesehatan, periode_id) wajib di-index pada file migration.

Pagination: Gunakan cursorPaginate(50) untuk tabel data utama, BUKAN paginate(), untuk menghindari lag pada offset besar.

Caching: Referensi wilayah (Daerah, Cabang, Ranting) wajib dicache menggunakan Redis.

Query Relasi: Hindari N+1 Problem. Jangan gunakan ->with() secara membabi buta. Gunakan lazy eager loading hanya jika datanya dirender di view.

Chunking/Job Queue: Untuk menu "Unduh Data" (Export), wajib menggunakan fitur chunk Laravel dan dieksekusi melalui Background Jobs / Queue agar server tidak RTO (Request Timeout).

Reaktivitas UI: Form bertingkat (wizard) dan logika dropdown wilayah bertingkat (Daerah -> Cabang -> Ranting) di-handle di client-side menggunakan Alpine.js (x-data, x-show, x-model).

2. MANAJEMEN PENGGUNA & HAK AKSES (RBAC)
Sistem menggunakan 2 Role utama:

Superadmin:

Akses penuh ke seluruh menu dan data.

Bisa ACC/Aktivasi akun Admin Ranting.

Mengelola Master Data Pengaturan (Pengguna & Periode).

Admin Ranting:

Hanya bisa melihat dan melakukan CRUD data yang memiliki ranting_id sesuai dengan wilayahnya.

Alur Pendaftaran: Mendaftar mandiri via Secret URL (misal: /register-admin-ranting-rahasia). Status default setelah daftar adalah is_active = false (menunggu ACC Superadmin).

3. DESAIN SKEMA DATABASE (ENTITY RELATIONSHIP)
Agent harus mengutamakan foreign key constraints dan indexing.

Tabel daerahs: id, nama_kabupaten_kota, no_sk, nama_wilayah, created_at, updated_at.

Tabel cabangs: id, daerah_id (FK), nama_kecamatan, no_sk, created_at, updated_at.

Tabel rantings: id, cabang_id (FK), nama_ranting, no_sk, created_at, updated_at.

Tabel periodes: id, tahun (contoh: 2026), is_active (boolean).

Tabel users: id, name, email, password, role (enum: superadmin, admin_ranting), ranting_id (FK, nullable untuk superadmin), is_active (boolean, default 0), remember_token, timestamps.

Tabel pendataan_keluargas (Untuk Menu Ranting Siaga):
id, periode_id (FK), user_id (FK), ranting_id (FK), nama_kk, umur, status_kawin (enum), pendidikan (enum), pekerjaan, alamat_dusun, no_rumah, indikator_gj (json), indikator_rmp (json), status_kesehatan (enum: jiwa, resiko, sehat), timestamps. (Index: ranting_id, periode_id, status_kesehatan).

Tabel kuesioner_mandiris (Untuk Menu Kuesioner SRQ-20):
id, periode_id (FK), user_id (FK), ranting_id (FK), nama, tanggal_mengisi, jenis_kelamin, status_kawin, umur, jumlah_anak, pendidikan, no_hp, pekerjaan, nik, agama, alamat, skor_srq (integer), interpretasi_srq (text), skor_kebiasaan (integer), interpretasi_kebiasaan (text), timestamps. (Index: nik, ranting_id).

4. SPESIFIKASI FITUR & MENU
4.1. Dashboard
Akses: Semua (Data difilter sesuai ranting_id untuk Admin Ranting).

Konten:

Widget Angka: Total Pendataan, Mengalami Gangguan Jiwa, Resiko, dan Sehat.

Grafik Garis (Line Chart): Menampilkan trend status kesehatan per tahun (menggunakan data dari tabel pendataan_keluargas di-group by periode_id).

Teknis: Gunakan Chart.js atau ApexCharts. Optimasi query count dengan agregat langsung dari database, jangan dilooping di PHP.

4.2. Menu Pendataan
Terdiri dari 2 Submenu:

A. Submenu Ranting Siaga Sehat Jiwa
UI/UX: Form elegan menggunakan Tailwind. Form 1 lembar per Kepala Keluarga.

Input Data: Nama KK, Umur, Status Kawin, Pendidikan, Pekerjaan, Alamat (Dusun, No Rumah).

Logika Sistem (SANGAT PENTING - Gunakan Alpine.js untuk live validation & PHP untuk backend validation):

Terdapat Checklist 10 tanda Gangguan Jiwa (Sedih berkepanjangan, dll).

Terdapat Checklist 6 tanda Resiko Masalah Psikososial (Kehilangan pekerjaan, hamil, dll).

Kondisi Status Akhir (Hierarki):

Jika salah satu atau lebih dari 10 tanda Gangguan Jiwa dicentang ➔ Status = Mengalami Gangguan Jiwa (mengabaikan inputan risiko/sehat).

Jika TIDAK ada tanda Gangguan Jiwa, TETAPI ada salah satu atau lebih dari 6 tanda Risiko ➔ Status = Resiko Masalah Psikososial.

Jika kedua checklist kosong ➔ Status = Sehat.

B. Submenu Kuesioner Laporan Mandiri (SRQ-20 & Kebiasaan)
UI/UX: Gunakan Alpine.js untuk membagi form menjadi 2 step/wizard tanpa reload halaman (x-show="step === 1", dst).

Step 1: Identitas & SRQ-20

Input: Nama, Tgl, JK, Status, Umur, Jml Anak, Pendidikan, No HP, Pekerjaan, NIK, Agama, Alamat.

20 Pertanyaan SRQ-20 (Radio button: Ya/Tidak).

Penilaian SRQ: Ya = 1, Tidak = 0.

Interpretasi Otomatis:

Skor 1-5 ➔ Tindak Lanjut: Edukasi (Pola hidup, Relaksasi, Manajemen Stres, Koping).

Skor >= 6 ➔ Tindak Lanjut: KIP-K, Manajemen faktor risiko, Rujukan.

Step 2: Kebiasaan Sehari-hari (30 Hari Terakhir)

8 Pertanyaan (Olahraga, Pengajian, Air putih, Tidur, Al Qur'an, Buah, Sayur, Aktifitas fisik).

Penilaian: Tidak Pernah = 1, Kadang = 2, Sering = 3, Selalu = 4.

Interpretasi Otomatis:

Skor 25-32: Kebiasaan Baik

Skor 16-24: Kebiasaan Cukup

Skor 8-15: Kebiasaan Kurang

Hasil Akhir: Setelah submit, munculkan Pop-up/Alert (dengan desain menarik via Tailwind/Alpine) yang menampilkan rangkuman hasil interpretasi SRQ dan Kebiasaan sebelum diarahkan ke halaman tabel/index.

4.3. Menu Unduh Data
Akses: Semua (Admin ranting hanya unduh datanya sendiri).

Fitur: Export data ke CSV/Excel.

Teknis: WAJIB menggunakan chunk query dan/atau Job Queue. Jangan me-load jutaan data ke RAM sekaligus.

4.4. Menu Pengaturan (Superadmin Only)
A. Submenu Pengguna
Tabel list akun (Superadmin & Admin Ranting).

Fitur: Tambah, Edit, Hapus, ACC/Aktivasi Akun (Toggle switch is_active menggunakan Alpine.js & fetch API/Axios).

B. Submenu Periode
Tabel pengaturan Tahun Periode Pendataan.

Hanya ada 1 periode yang berstatus "Aktif" pada satu waktu. Jika satu periode diaktifkan, periode lain otomatis inactive.

Fitur: CRUD Periode.

5. INSTRUKSI EKSEKUSI UNTUK AGENT (ANTIGRAVITY)
Agent, tolong jalankan pembuatan kode dengan urutan berikut:

Generate Migrations: Buat skema DB sesuai Bab 3 beserta index-nya.

Generate Models: Tulis relasi antar model (hasMany, belongsTo) dan fillable properties.

Generate Controllers & Middleware: Buat logika auth, RBAC middleware, dan fungsi CRUD biasa. Pastikan untuk fungsi index() pendataan menggunakan cursorPaginate().

Generate Views (Blade + Tailwind + Alpine): Integrasikan form statis dengan Alpine.js untuk menghitung logika SRQ-20 dan Gangguan Jiwa secara real-time di UI sebelum disubmit ke backend.
