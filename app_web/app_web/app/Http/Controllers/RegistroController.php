<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Usuario;
use App\Models\TipoDeDocumento;

class RegistroController extends Controller
{
    // Mostrar el formulario
    public function showForm()
    {
        $tiposDocumento = TipoDeDocumento::all();
        return view('registro', compact('tiposDocumento'));
    }

    // Guardar registro de usuario
    public function registrar(Request $request)
    {
        // Validación
        $request->validate([
            'nombre' => 'required|string|max:45',
            'apellido' => 'required|string|max:45',
            'documento' => 'required|string|max:35',
            'correo' => 'required|email|max:100|unique:usuario,Correo',  // Se asegura de que el correo sea único
            'fechadenacimiento' => 'required|date',
            'userPassword' => 'required|string|min:6',  // La contraseña debe tener al menos 6 caracteres
            'tipoDocumento' => 'required|exists:tipo_de_documento,idTipodedocumento',
            'acepto' => 'accepted',
        ]);

        // Crear el nuevo usuario
        Usuario::create([
            'Nombres' => $request->nombre,
            'Apellidos' => $request->apellido,
            'Documento' => $request->documento,
            'Correo' => $request->correo,
            'Contraseña' => Hash::make($request->userPassword),
            'FechaDeNacimiento' => $request->fechadenacimiento,
            'token' => Str::random(40),
            'Tipo_de_documento_idTipodedocumento' => $request->tipoDocumento,
            'Roles_idRoles' => 4, // ID del rol por defecto (ajústalo según tu base)
            'CodigoNis_idCodigoNis' => null, // Puedes cambiar esto si aplica
        ]);

        // Redirigir al login después de un registro exitoso
        return redirect()->route('login')->with('mensaje', 'Registro exitoso! Ahora puedes iniciar sesión.');
    }
}
