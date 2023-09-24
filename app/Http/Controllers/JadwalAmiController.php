<?php

namespace App\Http\Controllers;

use App\Models\HistoriAmi;
use App\Models\JadwalAmi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JadwalAmiController extends Controller
{
    public function index()
    {
        $data = [
            'jadwal_ami' => JadwalAmi::whereHas('historiAmi', function ($query) {
                $query->where('status', HistoriAmi::ACTIVE);
            })->latest()->paginate(10),
            'pelaksanaan_ami' => HistoriAmi::where('status', HistoriAmi::ACTIVE)->get()
        ];
        return view('ami.jadwal_ami.index', $data);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            "nama_jadwal" => "required",
            "jadwal_mulai" => "required",
            "jadwal_selesai" => "required",
            "histori_ami_id" => "required"
        ]);

        $request->merge([
            "status" => 1
        ]);

        DB::transaction(function () use ($request) {
            JadwalAmi::create($request->all());
        });
        return redirect(route('web.ami.jadwal-ami.index'))->with('message', 'Data Berhasil Tersimpan!');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $jadwalAmi = JadwalAmi::where('id', $id)->first();
        $data = [
            "update_jadwal" => $jadwalAmi,
            'pelaksanaan_ami' => HistoriAmi::all()
        ];
        return view('ami.jadwal_ami.edit', $data);
    }

    public function update(Request $request, string $id)
    {
        $jadwalAmi = JadwalAmi::findOrFail($id);
        $request->validate([
            "nama_jadwal" => "required",
            "jadwal_mulai" => "required",
            "jadwal_selesai" => "required",
            "histori_ami_id" => 'required'
        ]);

        DB::transaction(function () use ($request, $jadwalAmi) {
            $jadwalAmi->update([
                'nama_jadwal' => $request->nama_jadwal,
                'jadwal_mulai' => $request->jadwal_mulai,
                'jadwal_selesai' => $request->jadwal_selesai,
                'histori_ami_id' => $request->histori_ami_id
            ]);
        });
        return redirect(route('web.ami.jadwal-ami.index'))->with('message', 'Data Berhasil Tersimpan!');
    }

    public function destroy(string $id)
    {
        $jadwalAmi = JadwalAmi::findOrFail($id);
        DB::transaction(function () use ($jadwalAmi) {
            $jadwalAmi->delete();
        });
        return redirect(route('web.ami.jadwal-ami.index'))->with('message', 'Data Berhasil Terhapus!');
    }
}
