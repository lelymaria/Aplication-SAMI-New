<?php

namespace App\Http\Controllers;

use App\Models\HistoriAmi;
use App\Models\KepalaP4mp;
use App\Models\Level;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class KepalaP4mpController extends Controller
{
    public function index()
    {
        $level = Level::whereName(Level::KETUA_P4MP)->first();

        $data = [
            'kepala_p4mp' => User::whereHas('userHasLevelNotActive', function ($query) use ($level) {
                $query->whereLevelId($level->id);
            })->latest()->paginate(10)
        ];
        return view('manage_akun.p4mp.index', $data);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            "periode_jabatan" => "required",
            "email" => "required|email",
            "nip" => "required|unique:users,nip|numeric",
            "nama" => "required"
        ]);

        $histori_ami = HistoriAmi::whereStatus(HistoriAmi::ACTIVE)->first();
        if (!$histori_ami) {
            return redirect(route('web.manage-user.kepala-p4mp.index'))->with('error', 'Tahun AMI tidak tersedia!');
        }

        DB::transaction(function () use ($request, $histori_ami) {
            $level = Level::whereName(Level::KETUA_P4MP)->first();

            $user = User::create([
                'name' => $request->nama,
                'email' => $request->email,
                'nip' => $request->nip,
                'password' => Hash::make('password'),
                'foto_profile' => asset('images/profile/profile.png'),
            ]);

            $user->kepalaP4mp()->create([
                'periode_jabatan' => $request->periode_jabatan,
            ]);

            $user->userHasLevelNotActive()->create([
                'level_id' => $level->id,
                'histori_ami_id' => $histori_ami->id
            ]);
        });
        return redirect(route('web.manage-user.kepala-p4mp.index'))->with('message', 'Data Berhasil Tersimpan!');
    }

    public function show(string $id)
    {
    }

    public function edit(string $id)
    {
        $kepalaP4mp = User::findOrFail($id);
        $data = [
            'update_akun_kepalaP4mp' => $kepalaP4mp,
            'levels' => Level::all(),
            'histori_amis' => HistoriAmi::whereStatus(HistoriAmi::ACTIVE)->get()
        ];
        return view('manage_akun.p4mp.edit', $data);
    }

    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);
        $request->validate([
            "periode_jabatan" => "required",
            "email" => "required|email",
            "nip" => [
                'required',
                Rule::unique('users')->ignore($user->id),
                "numeric",
            ],
            "nama" => "required"
        ]);

        DB::transaction(function () use ($request, $user) {
            $user->update([
                'email' => $request->email,
                'nama' => $request->nama,
                'nip' => $request->nip,
            ]);

            $user->kepalaP4mp()->update([
                'periode_jabatan' => $request->periode_jabatan,
            ]);

            if ($request->histori_ami_id != $user->userHasLevelNotActive->histori_ami_id) {
                $user->userHasLevelNotActive()->create([
                    'level_id' => $request->level_id,
                    'histori_ami_id' => $request->histori_ami_id
                ]);
            } else {
                $user->userHasLevelNotActive()->update([
                    'level_id' => $request->level_id
                ]);
            }
        });
        return back()->with('message', 'Data Berhasil Tersimpan!');
    }

    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        DB::transaction(function () use ($user) {
            $user->forceDelete();
        });
        return redirect(route('web.manage-user.kepala-p4mp.index'))->with('message', 'Data Berhasil Terhapus!');
    }
}
