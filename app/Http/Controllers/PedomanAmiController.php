<?php

namespace App\Http\Controllers;

use App\Models\HistoriAmi;
use App\Models\PedomanAmi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PedomanAmiController extends Controller
{
    public function index()
    {
        $data = [
            'pedoman_ami' => PedomanAmi::whereHas('historiAmi', function ($query) {
                $query->where('status', 1);
            })->get()
        ];
        return view('ami.pedoman_ami.index', $data);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            "deskripsi" => "required",
            "file_pedoman" => "required|mimes:doc,docx,pdf|file|max:3072",
        ]);

        $histori_ami = HistoriAmi::whereStatus(HistoriAmi::ACTIVE)->first();
        if (!$histori_ami) {
            return redirect(route('web.ami.pedoman-ami.index'))->with('error', 'Tahun AMI tidak tersedia!');
        }

        $request->merge([
            "file_pedoman_ami" => $request->file('file_pedoman')->store('file_pedoman'),
            "histori_ami_id" => $histori_ami->id
        ]);

        DB::transaction(function () use ($request) {
            PedomanAmi::create($request->all());
        });

        return redirect(route('web.ami.pedoman-ami.index'))->with('message', 'Data Berhasil Tersimpan!');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $pedomanAmi = PedomanAmi::findOrFail($id);
        $data = [
            "update_pedoman" => $pedomanAmi,
        ];
        return view('ami.pedoman_ami.edit', $data);
    }

    public function update(Request $request, string $id)
    {
        $pedomanAmi = PedomanAmi::findOrFail($id);

        $request->validate([
            "deskripsi" => "required",
            "file_pedoman" => "mimes:doc,docx,pdf|file|max:3072"
        ]);

        if ($request->hasFile('file_pedoman')) {
            $request->merge([
                "file_pedoman_ami" => $request->file('file_pedoman')->store('file_pedoman'),
            ]);
        }

        DB::transaction(function () use ($request, $pedomanAmi) {
            $pedomanAmi->update($request->all());
        });

        return redirect(route('web.ami.pedoman-ami.index'))->with('message', 'Data Berhasil Tersimpan!');
    }

    public function destroy(string $id)
    {
        //
    }
}
