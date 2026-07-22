<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendakiBergabung extends Model
{
    protected $table = 'pendaki_bergabung';

    protected $guarded = [];

    /**
     * Ambil initial otomatis dari nama jika tidak diisi.
     */
    public function getInitialDisplayAttribute(): string
    {
        if (!empty($this->initial)) {
            return strtoupper(substr($this->initial, 0, 1));
        }

        return strtoupper(substr($this->nama, 0, 1));
    }

    /**
     * URL foto atau null jika tidak ada.
     */
    public function getFotoUrlAttribute(): ?string
    {
        if (!$this->foto) {
            return null;
        }

        // Jika sudah full URL atau path publik
        if (str_starts_with($this->foto, 'http') || str_starts_with($this->foto, '/')) {
            return $this->foto;
        }

        return '/storage/' . $this->foto;
    }
}
