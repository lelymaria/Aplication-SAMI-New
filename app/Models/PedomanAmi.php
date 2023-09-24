<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PedomanAmi extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    protected $table = 'pedoman_ami';

    protected $fillable = ['deskripsi', 'file_pedoman_ami', 'histori_ami_id'];

    public function historiAmi()
    {
        return $this->hasOne(HistoriAmi::class, 'id', 'histori_ami_id');
    }
}
