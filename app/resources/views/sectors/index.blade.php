<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>IoT Simulator - Precision Irrigation Logs</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f3f4f6; padding: 30px; }
        .container { max-width: 1250px; margin: 0 auto; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        h1 { color: #059669; border-bottom: 2px solid #ecfdf5; padding-bottom: 10px;}
        .form-group { display: grid; grid-template-columns: repeat(5, 1fr); gap: 10px; margin-bottom: 30px; }
        input { padding: 10px; border: 1px solid #d1d5db; border-radius: 6px; }
        button { background-color: #059669; color: white; border: none; padding: 10px; border-radius: 6px; cursor: pointer; font-weight: bold; transition: 0.3s; }
        button:hover { background-color: #047857; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #f9fafb; padding: 15px; text-align: left; color: #6b7280; font-size: 13px; }
        td { padding: 15px; border-bottom: 1px solid #f3f4f6; vertical-align: top; }
        .badge { padding: 5px 10px; border-radius: 20px; font-size: 12px; font-weight: bold; display: inline-block; margin-bottom: 5px;}
        .bg-red { background: #fee2e2; color: #ef4444; } 
        .bg-green { background: #dcfce7; color: #16a34a; }
        .bg-yellow { background: #fef08a; color: #854d0e; }
        .warning-box { background: #fee2e2; color: #b91c1c; padding: 8px; border-radius: 6px; font-size: 11px; font-weight: bold; margin-top: 10px; border: 1px solid #f87171;}
        .sim-box { display: flex; gap: 5px; margin-top: 10px; }
        .sim-input { width: 65px; padding: 5px; border: 1px solid #cbd5e1; border-radius: 4px; }
        .btn-siram { background-color: #3b82f6; width: 100%; margin-bottom: 5px; }
        .btn-siram:hover { background-color: #2563eb; }
        .btn-edit { background-color: #e2e8f0; color: #334155; width: 100%; text-align: center; text-decoration: none; display: inline-block; padding: 8px; border-radius: 6px; font-size: 12px; font-weight: 600; margin-bottom: 5px; box-sizing: border-box; border: 1px solid #cbd5e1; }
        .btn-edit:hover { background-color: #cbd5e1; }
        .history-container { max-height: 150px; overflow-y: auto; border: 1px solid #e2e8f0; padding: 8px; border-radius: 6px; background: #f8fafc; font-size: 11px; font-family: monospace; }
        .history-item { margin-bottom: 4px; border-bottom: 1px dashed #e2e8f0; padding-bottom: 4px; color: #334155; }
        .action-cell { display: flex; flex-direction: column; width: 140px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🎛️ IoT Simulator - Precision Irrigation Logs</h1>
        
        <form action="/sectors" method="POST" class="form-group">
            @csrf
            <input type="text" name="nama" placeholder="Nama Blok (Misal: Blok A)" required>
            <input type="text" name="tanaman" placeholder="Tanaman (Misal: Cabai)" required>
            <input type="number" name="ambang_batas" placeholder="Threshold Kelembaban (%)" required>
            <input type="number" name="frekuensi_ideal" placeholder="Batas Siram Sehari" required>
            <button type="submit">Tambah Lahan</button>
        </form>

        <table>
            <thead>
                <tr>
                    <th>Informasi Lahan</th>
                    <th>Status Saat Ini (Real-time)</th>
                    <th>Riwayat & Proteksi Over-Watering</th>
                    <th>Log Aliran Data Sensor (Time-series)</th>
                    <th>Aksi Kendali Sistem</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sectors as $s)
                @php
                    // Ambil log paling pertama (terbaru) untuk menampilkan status real-time saat ini
                    $latest_log = $s->logs->first();
                    $moisture_now = $latest_log ? $latest_log->kelembaban : 80;
                    $status_now = $latest_log ? $latest_log->status_pompa : 'PUMP OFF: STANDBY';
                    
                    $is_kritis = $moisture_now < $s->ambang_batas;
                    
                    // SEKARANG MEMBACA VARIABEL BARU DARI CONTROLLER (LOGIKA RESET TIAP HARI)
                    $jumlah_siram = $s->jumlah_siram_hari_ini; 
                    $is_over_water = $jumlah_siram > $s->frekuensi_ideal;
                @endphp
                <tr>
                    <td>
                        <strong>{{ $s->nama }}</strong><br>
                        <span style="font-size: 12px; color: #64748b;">🌱 Tanaman: {{ $s->tanaman }}</span><br>
                        <span style="font-size: 12px; color: #64748b;">🎯 Batas Min: {{ $s->ambang_batas }}%</span>
                    </td>
                    
                    <td>
                        <div style="font-size: 26px; font-weight: bold; color: {{ $is_kritis ? '#ef4444' : '#16a34a' }}">
                            {{ $moisture_now }}%
                        </div>
                        @if($is_kritis)
                            <span class="badge bg-red">🚨 POMPA ON</span>
                        @else
                            <span class="badge bg-green">✅ POMPA OFF</span>
                        @endif
                        
                        <form action="/sectors/{{ $s->id }}/set-kelembaban" method="POST" class="sim-box">
                            @csrf
                            <input type="number" name="kelembaban" class="sim-input" value="{{ $moisture_now }}" min="0" max="100" required>
                            <button type="submit" style="padding: 5px 8px; font-size: 11px; background: #64748b;">Set</button>
                        </form>
                    </td>
                    
                    <td>
                        <span class="badge bg-yellow">Disiram Hari Ini: {{ $jumlah_siram }} / {{ $s->frekuensi_ideal }} Kali</span>
                        @if($is_over_water)
                            <div class="warning-box">
                                ⚠️ PERINGATAN REPETISI!<br>
                                Frekuensi penyiraman melebihi batas reguler tanaman ({{ $s->frekuensi_ideal }}x). Risiko pembusukan akar tanaman!
                            </div>
                        @endif
                    </td>
                    
                    <td>
                        <div class="history-container">
                            @if($s->logs->isEmpty())
                                <div style="color: #94a3b8;">Belum ada log data...</div>
                            @else
                                @foreach($s->logs as $log)
                                    <div class="history-item">
                                        🕒 {{ $log->created_at->format('H:i:s') }} &rarr; 
                                        <span style="color: {{ str_contains($log->status_pompa, 'PUMP ON') ? '#ef4444' : '#16a34a' }}; font-weight: bold;">
                                            {{ $log->kelembaban }}%
                                        </span> 
                                        ({{ $log->status_pompa }})
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </td>
                    
                    <td>
                        <div class="action-cell">
                            <form action="/sectors/{{ $s->id }}/siram" method="POST">
                                @csrf
                                <button type="submit" class="btn-siram">💧 Siram Manual</button>
                            </form>
                            
                            <a href="/sectors/{{ $s->id }}/edit" class="btn-edit">⚙️ Edit Lahan</a>

                            <form action="/sectors/{{ $s->id }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit" style="background:#ef4444; width: 100%; font-size: 12px; padding: 8px;">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>