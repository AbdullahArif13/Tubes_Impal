<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | REGISTER (FORM)
    |--------------------------------------------------------------------------
    */
    public function showRegister()
    {
        return view('auth.register');
    }

    /*
    |--------------------------------------------------------------------------
    | REGISTER (ACTION)
    |--------------------------------------------------------------------------
    */
    public function register(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'telepon' => ['required','string','max:20','regex:/^08[0-9]{6,12}$/'],
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ], [
            'telepon.regex' => 'Nomor telepon harus diawali 08 dan berupa angka.',
        ]);

        // Buat user baru
        $user = User::create([
            'name' => $request->name,
            'telepon' => $request->telepon,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // =============== OPSIONAL ===============
        // Auto login setelah register
        Auth::login($user);
        // ========================================

        return redirect('/')
            ->with('success', 'Registrasi berhasil! Anda telah login.');
    }

    /*
    |--------------------------------------------------------------------------
    | LOGIN (FORM)
    |--------------------------------------------------------------------------
    */
    public function showLogin()
    {
        return view('auth.login');
    }

    /*
    |--------------------------------------------------------------------------
    | LOGIN (ACTION)
    |--------------------------------------------------------------------------
    */
    public function login(Request $request)
    {
        // Validasi
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Coba login
        if (Auth::attempt($credentials, $request->has('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended('/')
                ->with('success', 'Berhasil login!');
        }

        // Kalau gagal
        return back()
            ->withErrors(['email' => 'Email atau password salah.'])
            ->withInput();
    }

    /*
    |--------------------------------------------------------------------------
    | LOGOUT
    |--------------------------------------------------------------------------
    */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')
            ->with('success', 'Anda telah logout.');
    }
}
