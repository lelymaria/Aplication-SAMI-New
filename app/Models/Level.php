<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory, HasUuids;

    const OPERATOR = "Operator";

    const KETUA_P4MP = "Ketua P4MP";

    const LEAD_AUDITOR = "Lead Auditor";

    const ANGGOTA_AUDITOR = "Anggota Auditor";

    const AUDITEE = "Auditee";

    const JURUSAN = "Jurusan";

    const OTHERS = "Others";

    protected $fillable = ['name'];
}
