<?php
namespace App\Http\Controllers;
use App\Models\Sector;
use Illuminate\Http\Request;

class SectorController extends Controller {
    
    public function index() {
    $sectors = Sector::with('logs')->get();

    // Kita hitung jumlah siram HARI INI untuk setiap sektor sebelum dikirim ke view
    foreach ($sectors as $s) {
        $s->jumlah_siram_hari_ini = $s->logs()
            ->whereIn('status_pompa', ['PUMP ON: MENYIRAM', 'PUMP ON: MENYIRAM (MANUAL)'])
            ->whereDate('created_at', \Carbon\Carbon::today()) // Hanya hitung data hari ini
            ->count();
        }

    return view('sectors.index', compact('sectors'));
    }

    public function store(Request $request) {
        $sector = Sector::create($request->all());
        
        // Buat log pertama kali secara otomatis sebagai data awal (Default 80%)
        $sector->logs()->create([
            'kelembaban' => 80,
            'status_pompa' => 'PUMP OFF: STANDBY'
        ]);
        
        return redirect('/sectors');
    }

    public function edit(Sector $sector) {
        return view('sectors.edit', compact('sector'));
    }

    public function update(Request $request, Sector $sector) {
        $sector->update($request->all());
        return redirect('/sectors');
    }

    public function destroy(Sector $sector) {
        $sector->delete();
        return back();
    }

    // SIMULASI IoT: Setiap kali disiram, TAMBAH baris riwayat baru ke database
    public function siram(Sector $sector) {
        $sector->logs()->create([
            'kelembaban' => 100, // Disiram membuat tanah basah maksimal 100%
            'status_pompa' => 'PUMP ON: MENYIRAM (MANUAL)'
        ]);
        return back();
    }

    public function setKelembaban(Request $request, Sector $sector) {
    $kelembaban_input = $request->kelembaban;
        // 1. Jika kelembaban yang di-input berada di bawah ambang batas (KONDISI KRITIS)
        if ($kelembaban_input < $sector->ambang_batas) {
        // URUTAN PERTAMA: Catat log deteksi tanah kering (Pompa Mulai Menyala)
        $sector->logs()->create([
            'kelembaban' => $kelembaban_input,
            'status_pompa' => 'PUMP ON: MENYIRAM'
            ]);

        // URUTAN KEDUA (TERBARU): Karena pompa langsung menyiram, tanah berubah jadi basah (misal kita set 80%)
        // Logika Laravel .first() akan mengambil baris ini sebagai "Status Saat Ini"
        $sector->logs()->create([
            'kelembaban' => 80, // Sesuai contohmu, kelembaban setelah disiram menjadi 80%
            'status_pompa' => 'PUMP OFF: STANDBY (SELESAI)'
            ]);

        } else {
        
        // 2. Jika kelembaban yang di-input aman di atas ambang batas
        $sector->logs()->create([
            'kelembaban' => $kelembaban_input,
            'status_pompa' => 'PUMP OFF: STANDBY'
            ]);
        
        }

        return back();
    }
}