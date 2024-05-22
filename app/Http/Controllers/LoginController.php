<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Models\Publication;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

use App\Mail\UserRegistered;

class LoginController extends Controller
{
    // Muestra el formulario de registro
    public function showRegistrationForm()
    {
        if (Auth::check()) {
            return redirect()->route('index');
        }

        return view('auth.register');
    }

    // Maneja el registro del usuario
    public function register(RegisterRequest $request)
    {
        $user = new User();
        $user->username = $request->get('username');
        $user->email = $request->get('email');
        $user->password = Hash::make($request->get('password'));
        $user->phone = $request->get('phone');
        $user->role = 'usuario';
        $user->save();

        // Enviar correo al usuario recién registrado
        Mail::to($user->email)->send(new UserRegistered($user));

        // Enviar correo a todos los administradores
        $admins = User::where('role', 'administrador')->get();
        foreach ($admins as $admin) {
            Mail::to($admin->email)->send(new UserRegistered($user));
        }

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

    // Cargar la vista de index con la última publicación y con la más popular (en caso de empate la más reciente)
    public function index()
    {
        $latestPublication = Publication::latest()->first();
        $mostFavsPublication = Publication::withCount('favs')
            ->orderBy('favs_count', 'desc')
            ->orderBy('created_at', 'desc')  // En caso de empate
            ->first();
        return view('index', compact('latestPublication', 'mostFavsPublication'));
    }
}
