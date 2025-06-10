<?php
// app/Http/Controllers/Auth/LoginController.php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validar datos
        $request->validate([
            'correo' => 'required|email',
            'password' => 'required|string',
        ]);

        // Buscar usuario en la base de datos
        $usuario = Usuario::where('Correo', $request->correo)->first();

        // Verificar usuario y contraseña
        if ($usuario && Hash::check($request->password, $usuario->Contraseña)) {
            // Guardar en sesión manualmente (como no usas Auth::login aún)
            session(['idUsuario' => $usuario->idUsuario, 'rol' => $usuario->Roles_idRoles]);

            // Redireccionar según el rol
            switch ($usuario->Roles_idRoles) {
                case 1: // Administrador
                    return redirect()->route('admin.index');
                case 2: // Gerente
                    return redirect()->route('gerente.index');
                case 3: // Mesero
                    return redirect()->route('mesero.index');
                case 4: // Usuario
                    return redirect()->route('usuario.index');
                case 5: // Bartender
                    return redirect()->route('bartender.index');
                default:
                    return redirect()->route('home');
            }
        } else {
            return back()->withErrors(['correo' => 'Credenciales incorrectas'])->withInput();
        }
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect()->route('login')->with('mensaje', 'Cerraste sesión exitosamente.');
    }
}
