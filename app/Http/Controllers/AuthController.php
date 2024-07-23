<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function loginapi(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        $user = DB::table('users')->where('email', $email)->first();

        if (!$user || !password_verify($password, $user->password)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Cek jika peran pengguna adalah USER
        if ($user->roles !== 'USER') {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Generate token
        $token = bin2hex(random_bytes(32));

        // Save token to database or any storage mechanism you prefer
        DB::table('users')->where('id', $user->id)->update([
            'token' => $token
        ]);

        return response()->json([
            'token' => 'Bearer ' . $token,
            'nik' => $user->nik // Menambahkan NIK ke respons
        ], 200);
    }

    public function register(Request $request)
    {
        // Validasi untuk memeriksa jika tidak ada input yang diberikan
        if (!$request->hasAny(['nik', 'name', 'email', 'phone', 'password'])) {
            return response()->json(['error' => 'Tidak ada input yang diberikan'], 400);
        }

        $user = DB::table('users')->where('email', $request->email)->first();

        if ($user) {
            return response()->json(['error' => 'Email sudah terdaftar'], 400);
        }

        $hashedPassword = Hash::make($request->password);

        DB::table('users')->insert([
            'nik' => $request->nik,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => $hashedPassword,
            'roles' => 'USER' // Menambahkan peran USER
        ]);

        return response()->json(['message' => 'Registrasi berhasil'], 200);
    }

    public function getUserProfileByNik($nik)
    {
        $user = DB::table('users')->where('nik', $nik)->first();

        if (!$user) {
            return response()->json(['error' => 'Pengguna tidak ditemukan'], 404);
        }

        $userProfile = [
            'nik' => $user->nik,
            'nama' => $user->name,
            'email' => $user->email,
            'noHp' => $user->phone,
            'token' => $user->token,
        ];

        return response()->json($userProfile);
    }

}