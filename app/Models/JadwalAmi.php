<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JadwalAmi extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    protected $table = 'jadwal_ami';

    protected $fillable = ['nama_jadwal', 'jadwal_mulai', 'jadwal_selesai', 'histori_ami_id'];

    public function historiAmi()
    {
        return $this->hasOne(HistoriAmi::class, 'id', 'histori_ami_id');
    }
}
