<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // 1. FUNGSI REGISTRASI
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Membuat profil awal agar 'user_id' terisi otomatis
        UserProfile::create([
            'user_id' => $user->id, 
            'theme_mode' => 'system',
            'language' => 'id'
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Registrasi berhasil!',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ], 201);
    }

    // 2. FUNGSI LOGIN
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Email atau password salah.'], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login berhasil!',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ]);
    }

    // 3. FUNGSI UPDATE PROFILE
    public function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer', 
            'age' => 'required|integer',
            'average_cycle_length' => 'required|integer',
            'average_period_length' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Mencari profil berdasarkan user_id (FK) yang cocok dengan id (PK) user
        $profile = UserProfile::where('user_id', $request->id)->first();
        
        if (!$profile) {
            return response()->json([
                'message' => 'Profil tidak ditemukan untuk User ID: ' . $request->id
            ], 404);
        }

        try {
            $profile->update([
                'age' => $request->age,
                'average_cycle_length' => $request->average_cycle_length,
                'average_period_length' => $request->average_period_length,
            ]);

            return response()->json([
                'message' => 'Profil Lunara berhasil diperbarui!',
                'profile' => $profile
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal update database. Cek apakah kolom sudah ada di TablePlus.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}