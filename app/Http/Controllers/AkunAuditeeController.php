<?php

namespace App\Http\Controllers;

use App\Models\AkunAuditee;
use App\Models\HistoriAmi;
use App\Models\LayananAkademik;
use App\Models\Level;
use App\Models\ProgramStudi;
use App\Models\Standar;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AkunAuditeeController extends Controller
{
    public function index()
    {
        $level = Level::whereName(Level::AUDITEE)->first();
        $data = [
            'akun_auditee' => User::whereHas('userHasLevelNotActive', function ($query) use ($level) {
                $query->whereLevelId($level->id);
            })->latest()->paginate(10),
            'dataProdi' => ProgramStudi::all(),
            'layananAkademik' => LayananAkademik::all()
        ];
        return view('manage_akun.auditee.index', $data);
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
            "unit_kerja" => "required",
        ]);

        $histori_ami = HistoriAmi::where('status', 1)->first();
        if (!$histori_ami) {
            return redirect(route('web.manage-user.akun-auditee.index'))->with('error', 'Jadwal AMI tidak tersedia!');
        }

        DB::transaction(function () use ($request, $histori_ami) {
            $level = Level::where('name', 'Auditee')->first();

            $user = User::create([
                'nip' => $request->nip,
                'password' => Hash::make('password'),
                'level_id' => $level->id,
                'foto_profile' => asset('images/profile/profile.png'),
                'email' => $request->email,
                'name' => $request->nama,
            ]);

            $user->akunAuditee()->create([
                'unit_kerja_id' => $request->unit_kerja,
            ]);

            $user->userHasLevelNotActive()->create([
                'level_id' => $level->id,
                'histori_ami_id' => $histori_ami->id
            ]);
        });
        return redirect(route('web.manage-user.akun-auditee.index'))->with('message', 'Data Berhasil Tersimpan!');
    }

    public function show(AkunAuditee $akunAuditee)
    {
        //
    }

    public function edit(string $id)
    {
        $akunAuditee = User::find($id);
        $data = [
            'update_akun_auditee' => $akunAuditee,
            'dataProdi' => ProgramStudi::all(),
            'standar' => Standar::all(),
            'layananAkademik' => LayananAkademik::all(),
            'levels' => Level::all(),
            'histori_amis' => HistoriAmi::whereStatus(HistoriAmi::ACTIVE)->get()
        ];
        return view('manage_akun.auditee.edit', $data);
    }

    public function update(Request $request, string $id)
    {
        $akunAuditee = User::find($id);
        $request->validate([
            "unit_kerja" => "required",
            "email" => "required|email",
            "nip" => [
                'required', Rule::unique('users')->ignore($akunAuditee->id_user), "numeric"
            ],
            "nama" => "required"
        ]);

        DB::transaction(function () use ($request, $akunAuditee) {
            $akunAuditee->update([
                'nip' => $request->nip,
                'email' => $request->email,
                'name' => $request->nama,
            ]);

            if (!$akunAuditee->akunAuditee) {
                return $akunAuditee->akunAuditee()->create([
                    'unit_kerja_id' => $request->unit_kerja,
                ]);
            }

            if ($request->histori_ami_id != $akunAuditee->userHasLevelNotActive->histori_ami_id) {
                $akunAuditee->userHasLevelNotActive()->create([
                    'level_id' => $request->level_id,
                    'histori_ami_id' => $request->histori_ami_id
                ]);
            } else {
                $akunAuditee->userHasLevelNotActive()->update([
                    'level_id' => $request->level_id
                ]);
            }

            return $akunAuditee->akunAuditee()->update([
                'unit_kerja_id' => $request->unit_kerja
            ]);
        });
        return back()->with('message', 'Data Berhasil Tersimpan!');
    }

    public function destroy(string $id)
    {
        $akunAuditee = User::findOrFail($id);
        DB::transaction(function () use ($akunAuditee) {
            $akunAuditee->forceDelete();
        });
        return redirect(route('web.manage-user.akun-auditee.index'))->with('message', 'Data Berhasil Terhapus!');
    }
}
