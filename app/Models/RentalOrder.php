<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_code',
        'nama_lengkap',
        'nomor_wa',
        'nik_ktp',
        'alamat',
        'jenis_aktivitas',
        'tipe_pendakian',
        'tujuan_aktivitas',
        'tanggal_mulai',
        'tanggal_selesai',
        'tanggal_kembali',
        'foto_ktp',
        'items',
        'total_price',
        'status',
        'catatan',
    ];

    protected $casts = [
        'items' => 'array',
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'tanggal_kembali' => 'datetime',
        'total_price' => 'integer',
    ];

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'confirmed' => 'Barang Sewa',
            'washing' => 'Barang Sedang Dicuci',
            'completed' => 'Barang Ready',
            'cancelled' => 'Dibatalkan',
            default => 'Menunggu Konfirmasi',
        };
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status) {
            'confirmed' => 'bg-blue-100 text-blue-800 border-blue-200',
            'washing' => 'bg-cyan-100 text-cyan-800 border-cyan-200',
            'completed' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
            'cancelled' => 'bg-rose-100 text-rose-800 border-rose-200',
            default => 'bg-amber-100 text-amber-800 border-amber-200',
        };
    }
}
