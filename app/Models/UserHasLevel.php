<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserHasLevel extends Model
{
    use HasFactory, HasUuids;

    protected $guarded = [];

    public function level()
    {
        return $this->hasOne(Level::class, 'id', 'level_id');
    }

    public function historiAmi()
    {
        return $this->hasOne(HistoriAmi::class, 'id', 'histori_ami_id');
    }
}
