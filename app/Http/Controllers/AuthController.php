<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;

class AuthController extends Controller
{
    public function authenticate(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required|min:4'
        ], [
            'required' => ':attribute wajib diisi!',
            'min' => ':attribute minimal :min karakter!'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Email tidak terdaftar');
        }
        if (!Hash::check($request->password, $user->password)) {
            return redirect()->route('login')->with('error', 'Password salah');
        }

        if (!Auth::attempt($request->only('email', 'password'))) {
            return redirect()->route('login')->with('error', 'Email atau Password salah');
        }
        $request->session()->regenerate();
        return match ($user->role) {
            'administrator' => to_route('home'),
            'user' => to_route('home'),
        };
    }

    public function register(Request $request)
    {
        User::create([
            'id' => Uuid::uuid4()->toString(),
            'email' => $request->email,
            'name' => 'Admin',
            'password' => Hash::make($request->password),
            'role' => 'administrator',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
        return to_route('login');
    }
}
