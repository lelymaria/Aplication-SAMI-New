<?php

namespace App\Http\Controllers;

use App\Models\HistoriAmi;
use App\Models\Standar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StandarController extends Controller
{
    public function index()
    {
        $data = [
            'standar' => Standar::whereHas('historiAmi', function ($query) {
                $query->where('status', HistoriAmi::ACTIVE);
            })->latest()->paginate(10)
        ];
        return view('ami.standar.index', $data);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $histori_ami = HistoriAmi::where('status', HistoriAmi::ACTIVE)->first();
        if (!$histori_ami) {
            return redirect(route('web.ami.standar.index'))->with('error', 'tahun ami tidak tersedia!');
        }

        $request->validate([
            "nama_standar" => "required",
        ]);

        $request->merge([
            "histori_ami_id" => $histori_ami->id
        ]);

        DB::transaction(function () use ($request) {
            return Standar::create($request->all());
        });
        return redirect(route('web.ami.standar.index'))->with('message', 'Data Berhasil Tersimpan!');
    }

    public function show(Standar $standar)
    {
        //
    }

    public function edit(string $id)
    {
        $standar = Standar::findOrFail($id);

        $data = [
            "update_standar" => $standar
        ];

        return view('ami.standar.edit', $data);
    }

    public function update(Request $request, string $id)
    {
        $standar = Standar::findOrFail($id);

        $request->validate([
            "nama_standar" => "required"
        ]);

        DB::transaction(function () use ($request, $standar) {
            $standar->update($request->all());
        });

        return redirect(route('web.ami.standar.index'))->with('message', 'Data Berhasil Tersimpan!');
    }

    public function destroy(string $id)
    {
        $standar = Standar::findOrFail($id);

        DB::transaction(function () use ($standar) {
            $standar->delete();
        });

        return redirect(route('web.ami.standar.index'))->with('message', 'Data Berhasil Terhapus!');
    }
}
