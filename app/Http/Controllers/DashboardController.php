<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $now = Carbon::now();

        $data = [
            // "p4mpCount" => KepalaP4mp::count(),
            // "auditorCount" => AkunAuditor::count(),
            // "auditeeCount" => AkunAuditee::count(),
            // "jurusanCount" => AkunJurusan::count(),
            // "jadwalAmi" => JadwalAmi::where('jadwal_mulai', '<=', $now)
            //     ->where('jadwal_selesai', '>=', $now)
            //     ->whereYear('created_at', date('Y'))
            //     ->first(),
            "p4mpCount" => 0,
            "auditorCount" => 0,
            "auditeeCount" => 0,
            "jurusanCount" => 0,
            "jadwalAmi" => collect([
                "nama_jadwal" => "Kocak Beud",
                "jadwal_mulai" => Carbon::now(),
                "jadwal_selesai" => Carbon::now()->addYears(1)
            ]),
        ];

        return view('dashboard', $data);
    }
}
