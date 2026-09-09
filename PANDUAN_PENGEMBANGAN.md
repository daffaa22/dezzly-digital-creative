# Panduan Sistem & CMS Pengelolaan Konten (Dezzly Digital Creative)

Website **Dezzly Digital Creative** dilengkapi dengan **In-App Content Management System (CMS)** terintegrasi. Anda dapat mengontrol, mengubah, menambah proyek baru, mengedit harga layanan, memperbarui nomor WhatsApp, serta memantau pesan masuk dari calon klien tanpa perlu menyentuh kode pemrograman!

---

## 🎛️ Cara Mengakses & Masuk ke CMS Admin

Ada 3 cara mudah untuk membuka CMS Admin Portal:
1. Klik tombol **"CMS Admin"** di bagian kanan atas pada Navbar.
2. Klik tombol melayang (*floating button*) **"CMS Admin"** di pojok kanan bawah layar.
3. Klik tautan **"CMS Admin Portal"** di bagian Footer website.

### Kredensial Akses:
- **PIN Default**: `dezzly2026` (atau `admin`)
- **Akses Cepat**: Anda juga dapat langsung mengklik tombol **"⚡ Masuk Cepat (Akses Pemilik)"** untuk login instan.

---

## 📋 Fitur-Fitur Utama CMS Admin

### 1. 📊 Ringkasan (Overview)
- Menampilkan total proyek aktif, jumlah layanan, total testimoni, dan jumlah pesan *leads* calon klien.
- Menampilkan status kuota penerimaan proyek agensi (contoh: *Tersedia 3 Slot*).

### 2. 📁 Kelola Proyek & Studi Kasus (Projects Manager)
- **Tabel Daftar Proyek**: Melihat seluruh proyek yang sedang tayang di website.
- **Tambah Proyek Baru (+)**: Form interaktif untuk mengunggah studi kasus baru:
  - Judul, Nama Klien, Kategori (*Web & SaaS, Mobile Apps, AI & Otomasi, Branding & UI/UX*).
  - Industri, Tahun Rilis, Durasi Pengerjaan.
  - Gambar Cover URL, Ringkasan Produk (*Summary*).
  - Tantangan Klien (*The Challenge*) & Solusi Rekayasa (*The Solution*).
  - Metrik Dampak Nyata (contoh: `+340% Kenaikan Transaksi`).
  - *Tech Stack* (contoh: `React, TypeScript, Node.js, AWS`).
- **Edit Proyek**: Klik ikon pensil untuk mengubah data proyek kapan saja.
- **Hapus Proyek**: Klik ikon tempat sampah untuk menghapus proyek yang sudah tidak relevan.
- *Semua perubahan langsung tayang secara instan di halaman utama website!*

### 3. 📬 Kotak Masuk Leads & Konsultasi (Inquiries Inbox)
- Setiap kali ada pengunjung yang mengisi **Formulir Konsultasi Proyek** atau menggunakan **Kalkulator Estimasi Biaya**, data mereka otomatis masuk ke tab ini.
- Rincian yang tercatat:
  - Nama Calon Klien & Perusahaan.
  - Alamat Email & Nomor WhatsApp.
  - Rentang Estimasi Budget & Layanan yang Dicari.
  - Isi Pesan / Brief Kebutuhan.
- **Aksi Cepat**: Tersedia tombol **"Balas Langsung via WhatsApp"** yang otomatis membuka WhatsApp Web/App Anda dengan pesan pembuka ramah ke calon klien tersebut!
- Status pesan dapat diubah (*🟢 Baru, 🟡 Dihubungi, 🟣 Deal / Klien, ⚪ Arsip*).

### 4. 🛠️ Kelola Layanan (Services Manager)
- Melihat seluruh spektrum layanan agensi (*Web SaaS, Mobile App, Product Design, AI Solutions, Branding*).
- Menyesuaikan judul, deskripsi, daftar *deliverables*, dan patokan harga awal (*Starting Price*).

### 5. 🏢 Profil & Kontak Agensi (Agency Settings)
- **Nama Brand**: Mengubah nama agensi (*Dezzly Digital Creative*).
- **Kontak Resmi**: Mengubah nomor WhatsApp dan email resmi (akan otomatis memperbarui seluruh tombol chat di website).
- **Alamat & Jam Operasional**: Mengubah alamat kantor studio SCBD.
- **Stats Counter Hero**: Mengubah angka metrik di Hero banner (contoh: 48+ Produk, 99.2% CSAT, $42M+ Valuasi).

### 6. ⭐ Testimoni Klien
- Menambah ulasan baru dari klien yang puas (Nama, Jabatan, Perusahaan, Bintang Rating, dan Kutipan Ulasan).
- Menghapus testimoni lama.

### 7. 💾 Backup & Restore
- **Ekspor Backup JSON**: Klik untuk mengunduh seluruh data website (proyek, layanan, kontak, leads) ke dalam satu file `.json`.
- **Reset Data Default**: Mengembalikan seluruh data website ke pengaturan awal pabrik jika diperlukan.

---

## 💻 Cara Menjalankan Server Lokal & Build

Buka terminal di folder proyek:
```bash
cd C:\Users\ASUS\.gemini\antigravity-ide\scratch\agency-portfolio
```

- **Menjalankan Server Lokal**:
  ```bash
  npm run dev
  ```
  *Buka browser di `http://localhost:5173/`*
- **Membuat Versi Produksi**:
  ```bash
  npm run build
  ```

---
*Dikelola dengan bangga oleh Dezzly Digital Creative.*
