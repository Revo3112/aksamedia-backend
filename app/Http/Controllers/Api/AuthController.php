<?php
// app/Http/Controllers/Api/AuthController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\Admin;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $credentials = $request->validated();

            $admin = Admin::where('username', $credentials['username'])->first();

            if (!$admin || !Hash::check($credentials['password'], $admin->password)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Username atau password salah',
                    'data' => null
                ], 401);
            }

            // Revoke semua token yang ada
            $admin->tokens()->delete();

            // Buat token baru
            $token = $admin->createToken('api-token')->plainTextToken;

            return response()->json([
                'status' => 'success',
                'message' => 'Login berhasil',
                'data' => [
                    'token' => $token,
                    'admin' => [
                        'id' => $admin->id,
                        'name' => $admin->name,
                        'username' => $admin->username,
                        'phone' => $admin->phone,
                        'email' => $admin->email,
                    ]
                ]
            ], 200);

        }  catch (\Exception $e) {
            Log::error('Login Error: ' . $e->getMessage());
            Log::error($e->getTraceAsString());

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(), // <-- sekarang akan muncul pesan asli
            ], 500);
        }
    }

    public function logout(Request $request): JsonResponse
    {
        try {
            $request->user()->currentAccessToken()->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Logout berhasil',
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan server',
            ], 500);
        }
    }
}
