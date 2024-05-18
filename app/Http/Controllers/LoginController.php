<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    // Muestra el formulario de registro
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // Maneja el registro del usuario
    public function register(Request $request)
    {
        $user = new User();
        $user->username = $request->get('username');
        $user->email = $request->get('email');
        $user->password = Hash::make($request->get('password'));
        $user->phone = $request->get('phone');
        $user->role = 'usuario';
        $user->save();

        Auth::login($user);
        return redirect()->route('index');
    }

    // Maneja el inicio de sesión del usuario
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $rememberLogin = $request->filled('remember'); // Verifica si el checkbox está marcado

        // Verifica las credenciales manualmente
        $user = User::where('email', $credentials['email'])->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            if (Auth::attempt($credentials, $rememberLogin)) {
                $request->session()->regenerate();
                return redirect()->route('index');
            }
        } else {
            return back()->withErrors([
                'email' => 'Las credenciales no coinciden con nuestros registros.',
            ])->onlyInput('email');
        }

        return view('index');
    }

    // Maneja el cierre de sesión del usuario
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('index');
    }
}
