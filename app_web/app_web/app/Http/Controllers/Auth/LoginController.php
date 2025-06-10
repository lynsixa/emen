<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
        // Validar datos de entrada
        $request->validate([
            'correo' => 'required|email',
            'password' => 'required|string',
        ]);

        // Buscar usuario
        $usuario = Usuario::where('Correo', $request->correo)->first();

        if ($usuario && Hash::check($request->password, $usuario->Contraseña)) {
            // Iniciar sesión manualmente
            session([
                'idUsuario' => $usuario->idUsuario,
                'rol' => $usuario->Roles_idRoles,
            ]);

            // Redirigir según el rol
            switch ($usuario->Roles_idRoles) {
                case 1:
                    return redirect()->route('admin.index');
                    case 2:
                        return redirect()->route('gerente.index');  // Esta debe coincidir con el nombre de la ruta
                    
                case 3:
                    return redirect()->route('mesero.index');
                    case 4:
                        return redirect()->route('usuarios.codigonis.index');
                    
                case 5:
                    return redirect()->route('Bartender.index');
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
