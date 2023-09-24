<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AkunJurusan extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    protected $table = 'akun_jurusan';

    protected $fillable = ['jurusan_id', 'user_id'];

    public function jurusan()
    {
        return $this->hasOne(Jurusan::class, 'id', 'jurusan_id');
    }
}
