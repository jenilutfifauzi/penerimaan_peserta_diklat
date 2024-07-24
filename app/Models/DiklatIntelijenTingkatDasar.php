<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiklatIntelijenTingkatDasar extends Model
{
    use HasFactory;
    protected $table = 'peserta_pelatihans';
    protected $guarded = [];

    public function CodeDiklat()
    {
        return 'diklat_intelijen_tingkat_dasar';
    }

    public function getAgeAttribute()
    {
        return \Carbon\Carbon::parse($this->tanggal_lahir)->age;
    }
}
