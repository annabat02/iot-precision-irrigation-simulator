<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Konfigurasi Lahan</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f3f4f6; padding: 40px; }
        .container { max-width: 500px; margin: 0 auto; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        h1 { color: #059669; margin-bottom: 25px; font-size: 24px; border-bottom: 2px solid #ecfdf5; padding-bottom: 10px; }
        form { display: flex; flex-direction: column; gap: 15px; }
        label { font-weight: 600; color: #475569; font-size: 14px; }
        input { padding: 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px; }
        button { background-color: #059669; color: white; border: none; padding: 12px; border-radius: 6px; cursor: pointer; font-weight: bold; font-size: 14px; }
        button:hover { background-color: #047857; }
        .btn-cancel { background-color: #94a3b8; text-align: center; text-decoration: none; color: white; padding: 12px; border-radius: 6px; font-size: 14px; font-weight: bold; }
        .btn-cancel:hover { background-color: #64748b; }
    </style>
</head>
<body>
    <div class="container">
        <h1>⚙️ Edit Konfigurasi Sektor</h1>
        
        <form action="/sectors/{{ $sector->id }}" method="POST">
            @csrf
            @method('PUT') 
            
            <label>Nama Sektor / Blok:</label>
            <input type="text" name="nama" value="{{ $sector->nama }}" required>
            
            <label>Komoditas Tanaman:</label>
            <input type="text" name="tanaman" value="{{ $sector->tanaman }}" required>
            
            <label>Ambang Batas Kelembaban Minimum (%):</label>
            <input type="number" name="ambang_batas" value="{{ $sector->ambang_batas }}" min="1" max="100" required>
            
            <label>Batas Toleransi Frekuensi Siram Sehari (Kali):</label>
            <input type="number" name="frekuensi_ideal" value="{{ $sector->frekuensi_ideal }}" min="1" required>
            
            <button type="submit">💾 Simpan Perubahan</button>
            <a href="/sectors" class="btn-cancel">Batal</a>
        </form>
    </div>
</body>
</html>