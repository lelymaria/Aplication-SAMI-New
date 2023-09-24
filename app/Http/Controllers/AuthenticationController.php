<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthenticationController extends Controller
{
    public function index()
    {
        return view('auth.index');
    }

    public function login(Request $request)
    {
        DB::beginTransaction();
        try {
            $user = User::whereNip($request->nip)->first();

            if (!$user) {
                return back()->with('message', 'NIP is not available!');
            }
            if (!Hash::check($request->password, $user->password)) {
                return back()->with('message', 'Password is wrong!');
            }

            if (Auth::attempt([
                'nip' => $user->nip,
                'password' => $request->password
            ])) {
                $request->session()->regenerate();
                return redirect()->intended('dashboard');
            }

            DB::commit();
            return back();
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th);
        }
    }

    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/');
    }
}
