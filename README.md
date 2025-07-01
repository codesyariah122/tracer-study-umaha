# Tracer Study Universitas UMAHA

Website resmi Tracer Study untuk Universitas Maarif Hasyim Latif (UMAHA), dibangun untuk mengelola data alumni, pengguna lulusan, serta menyediakan rekapitulasi visual dalam bentuk grafik dan tabel interaktif.

🌐 Live Website: [https://tracer-study.umaha.demo-tokoweb.my.id/tracer-study-umaha/public/](https://tracer-study.umaha.demo-tokoweb.my.id/tracer-study-umaha/public/)

---

## 🔧 Built With

- [CodeIgniter 4](https://codeigniter.com/)
- [Bootstrap 5](https://getbootstrap.com/)
- [Highcharts](https://www.highcharts.com/)
- [DataTables](https://datatables.net/)

---

## 🎯 Features

### 🛠 Admin Dashboard
- CRUD data alumni & pengguna lulusan
- Manajemen form kuisioner
- Manajemen pengguna dan otorisasi

### 👥 Alumni User
- Halaman login khusus alumni UMAHA
- Form kuisioner tracer study alumni (dibutuhkan login)
- Edit dan kirim ulang jawaban

### 🏢 Pengguna Lulusan
- Form kuisioner terbuka untuk perusahaan / instansi
- Mengumpulkan feedback terhadap kualitas lulusan UMAHA

### 📊 Rekapitulasi & Visualisasi
- Ringkasan data kuisioner alumni & pengguna lulusan
- Tabel interaktif (DataTables)
- Grafik statistik (Highcharts)

---

## 🚀 Getting Started

1. **Clone the repository**  
   ```bash
   git clone https://github.com/namamu/tracer-study-umaha.git
   cd tracer-study-umaha
   ```  

2. Install dependencies & setup

    - Sesuaikan .env file dengan konfigurasi database kamu

    -   Jalankan migrasi dan seed jika tersedia  

3. Start the server  
```
php spark serve
```  

4. Akses di browser  
```
http://localhost:8080
```  

📁 Struktur Direktori Penting
    ```
        app/Controllers – Logic utama aplikasi

        app/Views – Tampilan berbasis Bootstrap

        app/Models – Query ke database

        public/ – Akses utama website (entry point)

        app/Database/Seeds – Seeder untuk data awal (jika tersedia)
    ```  

🙌 Kontribusi

Pull request dan issue sangat diterima! Pastikan kamu mengikuti gaya penulisan dan standar proyek ini.  

📄 License

Proyek ini didistribusikan untuk kebutuhan internal pengembangan Universitas UMAHA. Kontak pemilik repository untuk penggunaan lebih lanjut.

🧑‍💻 Developed by:  [Puji Ermanto | AKA Tatang. S | AKA Maman Salajami | AKA Deden Inyuus](https://pujiermanto-portfolio.vercel.app)