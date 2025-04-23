<?php

namespace App\Http\Controllers;

use App\Models\UserSetting;
use Illuminate\Http\Request;

class UserSettingController extends Controller
{
    public function index()
    {
        // Misal ambil user dengan ID 1 dulu (untuk simulasi)
        $user = UserSetting::find(1);

        return view('user-setting', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'username' => 'required|string',
            'email' => 'required|email',
            'phone' => 'nullable|string',
            'dob' => 'nullable|date',
            'gender' => 'nullable|in:Laki Laki,Perempuan',
            'two_step_verification' => 'string',
            'device' => 'nullable|string',
            'recovery_email' => 'nullable|email',
            'recovery_phone' => 'nullable|string',
            'security_notification' => 'string',
        ]);

        $user = UserSetting::findOrFail($id);
        $user->update($data);
        $user->dob = \Carbon\Carbon::parse($user->dob)->format('Y-m-d');
        //$user->dob = Carbon::createFromFormat('Y-m-d', $request->dob);

        return redirect()->back()->with('success', 'Pengaturan berhasil disimpan.');
    }
}
