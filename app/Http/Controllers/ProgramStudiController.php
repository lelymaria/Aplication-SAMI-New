<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProgramStudiController extends Controller
{
    public function index()
    {
        $data = [
            'prodi' => ProgramStudi::latest()->paginate(10),
            'jurusan' => Jurusan::all()
        ];
        return view('data.prodi.index', $data);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            "nama_prodi" => "required",
            "nama_jurusan" => "required",
        ]);

        $request->merge([
            "jurusan_id" => $request->nama_jurusan,
        ]);

        DB::transaction(function () use ($request) {
            ProgramStudi::create($request->all());
        });
        return redirect(route('web.data.prodi.index'))->with('message', 'Data Berhasil Tersimpan!');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $prodi = ProgramStudi::findOrFail($id);
        $data = [
            "update_prodi" => $prodi,
            "jurusan" => Jurusan::all()
        ];
        return view('data.prodi.edit', $data);
    }

    public function update(Request $request, string $id)
    {
        $prodi = ProgramStudi::findOrFail($id);
        $request->validate([
            "nama_prodi" => "required",
            "nama_jurusan" => "required",
        ]);

        $request->merge([
            "jurusan_id" => $request->nama_jurusan
        ]);

        DB::transaction(function () use ($request, $prodi) {
            $prodi->update($request->all());
        });
        return redirect(route('web.data.prodi.index'))->with('message', 'Data Berhasil Tersimpan!');
    }

    public function destroy(string $id)
    {
        $prodi = ProgramStudi::findOrFail($id);
        DB::transaction(function () use ($prodi) {
            $prodi->delete();
        });
        return redirect(route('web.data.prodi.index'))->with('message', 'Data Berhasil Terhapus!');
    }
}
