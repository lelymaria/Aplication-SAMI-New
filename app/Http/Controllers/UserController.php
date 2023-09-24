<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function updatePassword(Request $request, string $id)
    {
        $user = User::findOrFail($id);
        $request->validate([
            'new_password' => 'required|min:8',
            'new_password_confirmation' => 'required|min:8',
        ]);

        DB::transaction(function () use ($request, $user) {
            return $user->update(['password' => Hash::make($request->new_password)]);
        });

        return back()->with('message', 'Password Berhasil diUbah');
    }
}
