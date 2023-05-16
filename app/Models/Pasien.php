<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    use HasFactory;

    public function rumahSakit(){
        return $this->belongsTo(RumahSakit::class,'rumah_sakit','id');
    }
    protected $with = ['rumahSakit'];
}
