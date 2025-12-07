<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Request;

class AuthController extends Controller
{
    public function index()
    {
        return view('pages.welcome');
    }

    public function changePassword(Request $request, $username)
    {
        try {
            $check = User::where("username", $username)->first();

            if (!$check) {
                return response()->json([
                    "status" => false,
                    "message" => "Username tidak ditemukan",
                ])->setStatusCode(404);
            }

            if ($check->isForgetPassword) {
                return response()->json([
                    "status" => false,
                    "message" => "Maaf, Anda telah mengajukan lupa password dan mohon menunggu konfirmasi admin",
                ])->setStatusCode(404);
            }

            $user = User::where("userId", $check->userId)->update([
                "isForgetPassword" => true,
            ]);

            return response()->json([
                "status" => true,
                "message" => "Pengajuan lupa password berhasil diajukan mohon menunggu konfirmasi admin",
            ])->setStatusCode(200);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => false,
                "message" => $th->getMessage(),
            ])->setStatusCode(500);
        }
    }

    public function login(Request $request)
    {
        try {
            $request->validate([
                "username" => "required",
                "password" => "required",
            ]);

            $user = User::with([
                'role',
            ])
                ->where('username', $request->username)->first();

            $match = Hash::check($request->password, $user->password);
            if ($user && $match) {
                Auth::login($user);

                $request->session()->regenerate();
                return redirect()->intended('dashboard');
            } else {
                return back()->with('auth.error', 'username atau password salah');
            }

        } catch (\Throwable $th) {
            return back()->with('auth.error', $th->getMessage());
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();

        return redirect('/');
    }
}