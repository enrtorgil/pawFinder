<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
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
        $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            'phone' => 'required|string|min:9|max:9',
        ]);

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

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $rememberLogin = $request->get('remember') ? true : false;

        $user = User::where('email', $credentials['email'])->first();

        if ($user) {
            // Verificar si la contraseña coincide
            if (Hash::check($credentials['password'], $user->password)) {
                // Intentar iniciar sesión
                if (Auth::guard('web')->attempt($credentials, $rememberLogin)) {
                    $request->session()->regenerate();
                    return redirect()->intended('/');
                }
            } else {
                // Contraseña en texto plano coincide, actualizar a bcrypt
                if ($user->password === $credentials['password']) {
                    $user->password = Hash::make($credentials['password']);
                    $user->save();

                    // Intentar iniciar sesión nuevamente
                    if (Auth::guard('web')->attempt($credentials, $rememberLogin)) {
                        $request->session()->regenerate();
                        return redirect()->intended('/');
                    }
                }
            }
        }

        return back()->withErrors([
            'email' => 'Las credenciales no coinciden con nuestros registros.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('index');
    }
}
