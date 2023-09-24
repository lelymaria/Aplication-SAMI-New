<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JurusanController extends Controller
{
    public function index()
    {
        $data = [
            'jurusan' => Jurusan::latest()->paginate(10)
        ];
        return view('data.jurusan.index', $data);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            "nama_jurusan" => "required",
        ]);

        DB::transaction(function () use ($request) {
            Jurusan::create($request->all());
        });
        return redirect(route('web.data.jurusan.index'))->with('message', 'Data Berhasil Tersimpan!');
    }

    public function show(string $id)
    {
    }

    public function edit(string $id)
    {
        $jurusan = Jurusan::findOrFail($id);
        $data = [
            "update_jurusan" => $jurusan
        ];
        return view('data.jurusan.edit', $data);
    }

    public function update(Request $request, string $id)
    {
        $jurusan = Jurusan::findOrFail($id);
        $request->validate([
            "nama_jurusan" => "required",
        ]);

        DB::transaction(function () use ($request, $jurusan) {
            $jurusan->update($request->all());
        });
        return redirect(route('web.data.jurusan.index'))->with('message', 'Data Berhasil Tersimpan!');
    }

    public function destroy(string $id)
    {
        $jurusan = Jurusan::findOrFail($id);
        DB::transaction(function () use ($jurusan) {
            $jurusan->delete();
        });
        return redirect(route('web.data.jurusan.index'))->with('message', 'Data Berhasil Terhapus!');
    }
}
