<?php

namespace App\Http\Controllers;

use App\Models\AkunJurusan;
use App\Models\HistoriAmi;
use App\Models\Jurusan;
use App\Models\Level;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AkunJurusanController extends Controller
{
    public function index()
    {
        $level = Level::whereName(Level::JURUSAN)->first();

        $data = [
            'akun_jurusan' => User::whereHas('userHasLevelNotActive', function ($query) use ($level) {
                $query->whereLevelId($level->id);
            })->latest()->paginate(10),
            'dataJurusan' => Jurusan::all()
        ];
        return view('manage_akun.jurusan.index', $data);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            "email" => "required|email",
            "nip" => "required|unique:users,nip|numeric",
            "nama" => "required",
            "unit_kerja" => "required"
        ]);

        $histori_ami = HistoriAmi::whereStatus(HistoriAmi::ACTIVE)->first();
        if (!$histori_ami) {
            return redirect(route('web.manage-user.akun-jurusan.index'))->with('error', 'Tahun AMI tidak tersedia!');
        }

        DB::transaction(function () use ($request, $histori_ami) {
            $level = Level::whereName(Level::JURUSAN)->first();

            $user = User::create([
                'nip' => $request->nip,
                'password' => Hash::make('password'),
                'level_id' => $level->id,
                'foto_profile' => asset('images/profile/profile.png'),
                'email' => $request->email,
                'name' => $request->nama,
            ]);

            $user->akunJurusan()->create([
                'jurusan_id' => $request->unit_kerja
            ]);

            $user->userHasLevelNotActive()->create([
                'level_id' => $level->id,
                'histori_ami_id' => $histori_ami->id
            ]);
        });
        return redirect(route('web.manage-user.akun-jurusan.index'))->with('message', 'Data Berhasil Tersimpan!');
    }

    public function show(string $id)
    {
    }

    public function edit(string $id)
    {
        $akunJurusan = User::findOrFail($id);
        $data = [
            'update_akun_jurusan' => $akunJurusan,
            'dataJurusan' => Jurusan::all(),
            'levels' => Level::all(),
            'histori_amis' => HistoriAmi::whereStatus(HistoriAmi::ACTIVE)->get()
        ];
        return view('manage_akun.jurusan.edit', $data);
    }

    public function update(Request $request, string $id)
    {
        $akunJurusan = User::findOrFail($id);
        $request->validate([
            "unit_kerja" => "required",
            "email" => "required|email",
            "nip" => [
                'required', Rule::unique('users')->ignore($akunJurusan->id), "numeric"
            ],
            "nama" => "required"
        ]);

        DB::transaction(function () use ($request, $akunJurusan) {
            $akunJurusan->update([
                'email' => $request->email,
                'nama' => $request->nama,
                'foto_profile' => Hash::make('foto_profile'),
                'nip' => $request->nip
            ]);

            $akunJurusan->akunJurusan()->update([
                'jurusan_id' => $request->unit_kerja,
            ]);

            if ($request->histori_ami_id != $akunJurusan->userHasLevelNotActive->histori_ami_id) {
                $akunJurusan->userHasLevelNotActive()->create([
                    'level_id' => $request->level_id,
                    'histori_ami_id' => $request->histori_ami_id
                ]);
            } else {
                $akunJurusan->userHasLevelNotActive()->update([
                    'level_id' => $request->level_id
                ]);
            }
        });
        return back()->with('message', 'Data Berhasil Tersimpan!');
    }

    public function destroy(string $id)
    {
        $akunJurusan = User::findOrFail($id);
        DB::transaction(function () use ($akunJurusan) {
            $akunJurusan->forceDelete();
        });
        return redirect(route('web.manage-user.akun-jurusan.index'))->with('message', 'Data Berhasil Terhapus!');
    }
}
