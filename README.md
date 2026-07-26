# 🌿 Sistem Deteksi Keluarga: Ranting Siaga Sehat Jiwa
**Platform Pendataan Kesehatan Mental dan Psikososial Warga 'Aisyiyah se-Daerah Istimewa Yogyakarta**

---

## 🚀 Mengapa Sistem Ini Hadir?

Kesehatan jiwa adalah pilar utama kesejahteraan keluarga. **Sistem Deteksi Keluarga** hadir sebagai solusi digital terintegrasi untuk memetakan, mendeteksi, dan menganalisis status kesehatan mental serta risiko psikososial jutaan warga di tingkat Ranting secara *real-time*. 

Dirancang khusus untuk menangani skala data masif (hingga 3 juta+ data warga) dengan antarmuka yang sangat responsif, sistem ini memberdayakan para kader dan pengurus 'Aisyiyah untuk mengambil keputusan berbasis data (*data-driven*) dengan cepat, tepat, dan akurat.

---

## ✨ Fitur Unggulan

### 📊 1. Dashboard Analitik Cerdas
Tidak ada lagi data yang berserakan. Dashboard menyajikan ringkasan visual yang indah dan mudah dipahami:
- **Statistik Komprehensif:** Menampilkan total warga yang terdata dengan metrik yang jelas.
- **Grafik Tren Kesehatan (Line Chart):** Visualisasi interaktif per tahun yang memetakan pergerakan status kesehatan warga: *Mengalami Gangguan Jiwa*, *Risiko Masalah Psikososial*, dan *Sehat*.
- **Performa Responsif:** Mampu merender agregasi jutaan data dalam hitungan milidetik.

### 📝 2. Pendataan Ranting Siaga Sehat Jiwa (Auto-Diagnosis)
Proses input data yang dirancang sangat intuitif bagi kader di lapangan, mencakup data demografi lengkap (Kepala Keluarga, Umur, Status, Pendidikan, Pekerjaan, Alamat).
- **Logika Deteksi Otomatis:** Sistem secara pintar akan menentukan status akhir kesehatan warga berdasarkan input gejala. 
  - *Sistem memprioritaskan indikasi Gangguan Jiwa (seperti sedih berkepanjangan, menyendiri). Jika tidak terpenuhi, sistem akan mengevaluasi Risiko Psikososial (seperti kehilangan pekerjaan, penyakit kronis).*
- **Satu Pintu:** Semua indikator disatukan dalam satu antarmuka formulir yang cantik dan tidak membingungkan.

### 🧠 3. Kuesioner Laporan Mandiri (SRQ-20)
Modul khusus untuk asesmen mandiri yang lebih mendalam:
- **Formulir Gejala (20 Pertanyaan):** Mengadaptasi standar kuisioner kesehatan mental untuk mendeteksi tingkat stres, kecemasan, dan depresi.
- **Tracking Kebiasaan Hidup (30 Hari Terakhir):** Melacak gaya hidup warga mulai dari rutinitas olahraga, durasi tidur, konsumsi air putih, hingga rutinitas ibadah (mengaji & membaca Al-Qur'an).

### 🔒 4. Manajemen Akses Berlapis & Aman (Superadmin & Admin Ranting)
Sistem ini menggunakan arsitektur keamanan *Role-Based Access Control* (RBAC) yang terisolasi:
- **Admin Ranting (Mandiri & Terfokus):** Admin ranting mendaftar melalui jalur khusus dan hanya memiliki wewenang mengelola data di wilayah rantingnya sendiri. Memastikan privasi data antar wilayah tetap terjaga.
- **Superadmin (God-Mode):** Memiliki kontrol penuh atas seluruh sistem. Dilengkapi dengan fitur **Approval Akun Admin Ranting** untuk mencegah akses dari pihak yang tidak bertanggung jawab.

### ⚙️ 5. Pengaturan Dinamis & Ekspor Data
Sistem tidak akan lekang oleh waktu karena dirancang sangat dinamis:
- **Manajemen Periode (Per Tahun):** Superadmin dapat membuka atau menutup periode pendataan setiap tahunnya, memastikan data historis tersimpan rapi tanpa tercampur.
- **Manajemen Pengguna:** Pengelolaan belasan ribu akun admin wilayah dengan fitur pencarian dan filter yang sangat cepat.
- **Unduh Data (Export):** Ekstrak hasil pendataan kapan saja untuk kebutuhan laporan cetak, audit, atau analisis lanjutan.

---

## 🛠️ Teknologi di Balik Layar

Sistem ini ditenagai oleh kombinasi arsitektur modern yang menjamin kecepatan dan keandalan tinggi:
*   **Laravel 12:** Sebagai *backend engine* yang sangat tangguh untuk memproses *business logic* dan keamanan tingkat tinggi.
*   **Alpine.js:** Memberikan reaktivitas antarmuka (*client-side*) selembut aplikasi *Single Page Application* tanpa membebani performa *browser*.
*   **Tailwind CSS:** Menghasilkan desain antarmuka (UI) yang modern, bersih, dan responsif di berbagai ukuran layar.
*   **Optimasi MySQL Skala Besar:** Skema *database* telah dioptimasi dengan teknik *Composite Indexing* dan *Cursor Pagination* untuk menjamin sistem tidak melambat meski menampung jutaan baris data.

---
*Dikembangkan secara dedikatif untuk mewujudkan keluarga dan masyarakat yang sehat secara fisik, mental, dan spiritual.*
