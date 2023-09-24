<?php

namespace App\Http\Controllers;

use App\Models\HistoriAmi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PelaksanaanAmiController extends Controller
{
    public function index()
    {
        $data = [
            'pelaksanaan_ami' => HistoriAmi::latest()->paginate(10)
        ];
        return view('ami.pelaksanaan_ami.index', $data);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            "tahun_ami" => "required"
        ]);

        $request->merge([
            "status" => 1
        ]);

        DB::transaction(function () use ($request) {
            HistoriAmi::create($request->all());
        });
        return redirect(route('web.ami.pelaksanaan-ami.index'))->with('message', 'Data Berhasil Tersimpan!');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $pelaksanaan_ami = HistoriAmi::findOrFail($id);
        $data = [
            "update_pelaksanaan" => $pelaksanaan_ami
        ];
        return view('ami.pelaksanaan_ami.edit', $data);
    }

    public function update(Request $request, string $id)
    {
        $pelaksanaan_ami = HistoriAmi::findOrFail($id);
        $request->validate([
            "tahun_ami" => "required"
        ]);

        DB::transaction(function () use ($request, $pelaksanaan_ami) {
            $pelaksanaan_ami->update($request->all());
        });
        return redirect(route('web.ami.pelaksanaan-ami.index'))->with('message', 'Data Berhasil Tersimpan!');
    }

    public function destroy(string $id)
    {
        $pelaksanaan_ami = HistoriAmi::findOrFail($id);
        DB::transaction(function () use ($pelaksanaan_ami) {
            $pelaksanaan_ami->delete();
        });
        return redirect(route('web.ami.pelaksanaan-ami.index'))->with('message', 'Data Berhasil Terhapus!');
    }

    public function nonActive(Request $request)
    {
        $histori = HistoriAmi::findOrFail($request->id_tahun_ami);
        DB::transaction(function () use ($histori) {
            $histori->update([
                'status' => HistoriAmi::NO_ACTIVE
            ]);
        });

        return redirect(route('web.ami.pelaksanaan-ami.index'))->with('message', 'Jadwal AMI Berhasil di Non-Aktifkan!');
    }
}
