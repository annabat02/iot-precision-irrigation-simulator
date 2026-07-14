<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class SensorLog extends Model {
    protected $fillable = ['sector_id', 'kelembaban', 'status_pompa'];

    public function sector() {
        return $this->belongsTo(Sector::class);
    }
}