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
            'name'          => 'required|string|max:255',
            'phone'         => 'required|string|min:10|max:15',
            'address'       => 'required|string',
            'province_id'   => 'nullable|string',
            'city_id'       => 'nullable|string',
            'district_id'   => 'nullable|string',
            'province_name' => 'nullable|string',
            'city_name'     => 'nullable|string',
            'district_name' => 'nullable|string',
        ]);

        $user = Auth::user();
        $user->update([
            'name'          => $request->name,
            'phone'         => $request->phone,
            'address'       => $request->address,
            'province_id'   => $request->province_id,
            'city_id'       => $request->city_id,
            'district_id'   => $request->district_id,
            'province_name' => $request->province_name,
            'city_name'     => $request->city_name,
            'district_name' => $request->district_name,
        ]);

        return redirect()
            ->route('akun.index')
            ->with('success', 'Data akun berhasil diperbarui');
    }
}
