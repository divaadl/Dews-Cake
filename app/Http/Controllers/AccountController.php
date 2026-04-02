<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    // HALAMAN DATA FIX
    public function index()
    {
        $user = Auth::user();
        return view('akun.index', compact('user'));
    }

    // HALAMAN FORM EDIT
    public function edit()
    {
        $user = Auth::user();
        return view('akun.edit', compact('user'));
    }

    // PROSES UPDATE
    public function update(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'phone'   => 'required|string|min:10|max:15',
            'address' => 'required|string',
        ]);

        $user = Auth::user();
        $user->update([
            'name'    => $request->name,
            'phone'   => $request->phone,
            'address' => $request->address,
        ]);

        return redirect()
            ->route('akun.index')
            ->with('success', 'Data akun berhasil diperbarui');
    }
}
