<?php

namespace App\Http\Controllers;

use App\Models\HistoriAmi;
use App\Models\Level;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AkunOperatorController extends Controller
{
    public function index()
    {
        $level = Level::whereName(Level::OPERATOR)->first();
        $data = [
            'akun_operator' => User::whereHas('userHasLevelNotActive', function ($query) use ($level) {
                $query->whereLevelId($level->id);
            })->latest()->paginate(10)
        ];
        return view('manage_akun.operator.index', $data);
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
        ]);

        DB::transaction(function () use ($request) {
            $level = Level::whereName(Level::OPERATOR)->first();
            $histori_ami = HistoriAmi::whereStatus(HistoriAmi::ACTIVE)->first();

            $user = User::create([
                'name' => $request->nama,
                'email' => $request->email,
                'nip' => $request->nip,
                'password' => Hash::make('password'),
                'level_id' => $level->id,
                'foto_profile' => asset('images/profile/profile.png'),
            ]);

            $user->userHasLevelNotActive()->create([
                'level_id' => $level->id,
                'histori_ami_id' => $histori_ami->id
            ]);
        });
        return redirect(route('web.manage-user.akun-operator.index'))->with('message', 'Data Berhasil Tersimpan!');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $akunOperator = User::findOrFail($id);

        $data = [
            'update_akun_operator' => $akunOperator,
            'levels' => Level::all()
        ];

        return view('manage_akun.operator.edit', $data);
    }

    public function update(Request $request, string $id)
    {
        $akunOperator = User::findOrFail($id);

        $request->validate([
            "email" => "required|email",
            "nip" => [
                "numeric",
                'required',
                Rule::unique('users')->ignore($akunOperator->id)
            ],
            "nama" => "required"
        ]);

        DB::transaction(function () use ($request, $akunOperator) {
            $akunOperator->update([
                'email' => $request->email,
                'name' => $request->nama,
                'nip' => $request->nip,
            ]);

            $akunOperator->userHasLevelNotActive()->update([
                'level_id' => $request->level_id
            ]);
        });

        return back()->with('message', 'Data Berhasil Tersimpan!');
    }

    public function destroy(string $id)
    {
        $akunOperator = User::findOrFail($id);

        DB::transaction(function () use ($akunOperator) {
            $akunOperator->forceDelete();
        });

        return redirect(route('web.manage-user.akun-operator.index'))->with('message', 'Data Berhasil Terhapus!');
    }
}
