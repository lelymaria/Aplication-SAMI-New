<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AkunAuditor extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    protected $table = 'akun_auditor';

    protected $fillable = ['unit_kerja_id', 'user_id'];

    public function user()
    {
        return $this->hasOne(User::class,  'id', 'user_id');
    }

    public function prodi()
    {
        return $this->belongsTo(ProgramStudi::class, 'unit_kerja_id', 'id');
    }

    public function layananAkademik()
    {
        return $this->hasOne(LayananAkademik::class,  'id', 'unit_kerja_id');
    }
}
