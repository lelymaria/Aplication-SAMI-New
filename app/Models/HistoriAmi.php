<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HistoriAmi extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    const ACTIVE = 1;

    const NO_ACTIVE = 0;

    protected $table = 'histori_ami';
    protected $fillable = ['tahun_ami', 'status'];
}
