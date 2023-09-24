<?php

namespace App\Http\Controllers;

use App\Models\LayananAkademik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LayananAkademikController extends Controller
{
    public function index()
    {
        $data = [
            'layanan' => LayananAkademik::latest()->paginate(10)
        ];

        return view('data.layanan_akademik.index', $data);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            "nama_layanan" => "required",
        ]);

        DB::transaction(function () use ($request) {
            LayananAkademik::create($request->all());
        });

        return redirect(route('web.data.layanan-akademik.index'))->with('message', 'Data Berhasil Tersimpan!');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $layanan = LayananAkademik::findOrFail($id);

        $data = [
            "update_layanan" => $layanan
        ];

        return view('data.layanan_akademik.edit', $data);
    }

    public function update(Request $request, string $id)
    {
        $layanan = LayananAkademik::findOrFail($id);

        $request->validate([
            "nama_layanan" => "required",
        ]);

        DB::transaction(function () use ($request, $layanan) {
            $layanan->update($request->all());
        });

        return redirect(route('web.data.layanan-akademik.index'))->with('message', 'Data Berhasil Tersimpan!');
    }

    public function destroy(string $id)
    {
        $layanan = LayananAkademik::findOrFail($id);

        DB::transaction(function () use ($layanan) {
            $layanan->delete();
        });

        return redirect(route('web.data.layanan-akademik.index'))->with('message', 'Data Berhasil Terhapus!');
    }
}
