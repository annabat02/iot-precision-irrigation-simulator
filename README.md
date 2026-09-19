# 2. Repositori: `iot-precision-irrigation-simulator`[cite: 15]


# IoT Precision Irrigation Simulator & Monitoring Dashboard

Aplikasi simulasi dasbor pemantauan sistem irigasi presisi berbasis web. Proyek ini memodelkan alur logika otomasi distribusi air berdasarkan ambang batas (*threshold*) kelembapan tanah serta integrasi lingkungan kerja terisolasi dengan Docker.


## 📌 Alur Logika Sistem
1. **Penerimaan Parameter Lingkungan:** Menerima input kondisi kelembapan tanah (simulasi data telemetri sensor).
2. **Evaluasi Threshold Dinamis:**
   * **Kondisi Kering:** Nilai kelembapan berada di bawah ambang batas minimal; sistem memicu status peringatan butuh penyiraman.
   * **Kondisi Optimal/Basah:** Nilai kelembapan memenuhi kebutuhan tanaman; pompa air/katup dihentikan.
3. **Rekomendasi Berbasis Komoditas:** Modul logika memberikan rekomendasi volume dan durasi penyiraman yang disesuaikan dengan jenis tanaman tertentu.
4. **CRUD Data Operasional:** Pencatatan, pembaruan, dan riwayat log kondisi kelembapan tanah dan jadwal penyiraman.

---

## ✨ Fitur Utama
* **Dashboard Monitoring:** Visualisasi status kelembapan tanah secara real-time berdasarkan evaluasi batas kondisi.
* **Manajemen Data (CRUD):** Pengelolaan master data jenis tanaman, konfigurasi ambang batas, dan log operasional.
* **Decision Support Logic:** Rekomendasi tindakan otomatis untuk efisiensi penggunaan volume air irigasi.
* **Containerized Environment:** Konfigurasi lingkungan aplikasi terisolasi untuk kemudahan penyebaran (*deployment*).

---

## 🛠️ Tumpukan Teknologi
* **Bahasa & Antarmuka:** PHP, CSS3, JavaScript[cite: 2, 3]
* **Basis Data:** MySQL
* **Kontainerisasi:** Docker & Docker Compose

---

## 🚀 Panduan Menjalankan

### Opsi 1: Menggunakan Docker (Direkomendasikan)
```bash
# Klon repositori
git clone [https://github.com/annabat02/iot-precision-irrigation-simulator.git](https://github.com/annabat02/iot-precision-irrigation-simulator.git)
cd iot-precision-irrigation-simulator

# Jalankan kontainer
docker-compose up -d
Akses dasbor pada peramban melalui http://localhost:8080 (sesuai port pemetaan Docker).

Opsi 2: Web Server Lokal Tradisional
Pindahkan folder ke direktori server lokal (htdocs atau www).

Impor basis data MySQL.

Jalankan web server (Laragon/XAMPP) dan akses via http://localhost/iot-precision-irrigation-simulator.
