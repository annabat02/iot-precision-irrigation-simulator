<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Sector extends Model {
    protected $fillable = ['nama', 'tanaman', 'ambang_batas', 'frekuensi_ideal'];

    // Relasi: 1 Sektor memiliki BANYAK catatan riwayat sensor
    public function logs() {
        return $this->hasMany(SensorLog::class)->latest(); // Urutkan dari yang terbaru
    }
}