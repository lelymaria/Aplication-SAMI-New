<?php

namespace App\Http\Controllers;

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

class LeadAuditorController extends Controller
{
    public function index()
    {
        $level = Level::whereName(Level::LEAD_AUDITOR)->first();
        $data = [
            'akun_auditor' => User::whereHas('userHasLevel', function ($query) use ($level) {
                $query->whereLevelId($level->id);
            })->latest()->paginate(10),
            'dataProdi' => ProgramStudi::all(),
            'layananAkademik' => LayananAkademik::all()
        ];
        return view('manage_akun.auditor.lead.index', $data);
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
            return redirect(route('web.manage-user.lead-auditor.index'))->with('error', 'jadwal ami tidak tersedia!');
        }

        DB::transaction(function () use ($request, $histori_ami) {
            $level = Level::where('name', 'Lead Auditor')->first();

            $user = User::create([
                'nip' => $request->nip,
                'password' => Hash::make('password'),
                'level_id' => $level->id,
                'foto_profile' => asset('images/profile/profile.png'),
                'email' => $request->email,
                'name' => $request->nama,
            ]);

            $user->akunAuditor()->create([
                'unit_kerja_id' => $request->unit_kerja,
            ]);

            $user->userHasLevelNotActive()->create([
                'level_id' => $level->id,
                'histori_ami_id' => $histori_ami->id
            ]);
        });

        return redirect(route('web.manage-user.lead-auditor.index'))->with('message', 'Data Berhasil Tersimpan!');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $akunAuditor = User::find($id);
        $data = [
            'update_akun_auditor' => $akunAuditor,
            'dataProdi' => ProgramStudi::all(),
            'standar' => Standar::latest()->paginate(5),
            'layananAkademik' => LayananAkademik::all(),
            'levels' => Level::all(),
            'histori_amis' => HistoriAmi::whereStatus(HistoriAmi::ACTIVE)->get()
        ];
        return view('manage_akun.auditor.lead.edit', $data);
    }

    public function update(Request $request, string $id)
    {
        $akunAuditor = User::find($id);
        $request->validate([
            "unit_kerja" => "required",
            "email" => "required|email",
            "nip" => [
                'required', Rule::unique('users')->ignore($akunAuditor->id), 'numeric',
            ],
            "nama" => "required"
        ]);

        $histori_ami = HistoriAmi::whereStatus(HistoriAmi::ACTIVE)->first();
        if (!$histori_ami) {
            return redirect(route('web.manage-user.lead-auditor.index'))->with('error', 'Jadwal AMI tidak tersedia!');
        }

        DB::transaction(function () use ($request, $akunAuditor, $histori_ami) {
            $akunAuditor->update([
                'nip' => $request->nip,
                'email' => $request->email,
                'name' => $request->nama,
            ]);

            if (!$akunAuditor->akunAuditor) {
                return $akunAuditor->akunAuditor()->create([
                    'unit_kerja_id' => $request->unit_kerja,
                ]);
            }

            if ($request->histori_ami_id != $akunAuditor->userHasLevelNotActive->histori_ami_id) {
                $akunAuditor->userHasLevelNotActive()->create([
                    'level_id' => $request->level_id,
                    'histori_ami_id' => $request->histori_ami_id
                ]);
            } else {
                $akunAuditor->userHasLevelNotActive()->update([
                    'level_id' => $request->level_id
                ]);
            }

            return $akunAuditor->akunAuditor()->update([
                'unit_kerja_id' => $request->unit_kerja
            ]);
        });

        return back()->with('message', 'Data Berhasil Tersimpan!');
    }

    public function destroy(string $id)
    {
        $akunAuditor = User::findOrFail($id);
        DB::transaction(function () use ($akunAuditor) {
            $akunAuditor->forceDelete();
        });
        return redirect(route('web.manage-user.lead-auditor.index'))->with('message', 'Data Berhasil Terhapus!');
    }
}
