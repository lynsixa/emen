<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\TipoDeDocumento;
use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsuarioController extends Controller
{
    // Mostrar todos los usuarios
    public function index()
    {
        $usuarios = Usuario::all();  // Obtener todos los usuarios
        return view('admin.usuario.index', compact('usuarios'));
    }

    // Mostrar el formulario para crear un nuevo usuario
    public function create()
    {
        // Obtener todos los tipos de documentos y roles
        $tipos = TipoDeDocumento::all();
        $roles = Rol::all();

        return view('admin.usuario.create', compact('tipos', 'roles'));
    }

    // Guardar un nuevo usuario
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'Nombres' => 'required|string|max:45',
            'Apellidos' => 'required|string|max:45',
            'Documento' => 'required|string|max:35|unique:usuario,Documento', // Verificar que el documento sea único
            'Correo' => 'required|string|email|max:100|unique:usuario,Correo',  // Verificar que el correo sea único
            'Contraseña' => 'required|string|min:8|confirmed', // Confirmación de contraseña
            'FechaDeNacimiento' => 'required|date',
            'Tipo_de_documento_idTipodedocumento' => 'required|exists:tipo_de_documento,idTipodedocumento',
            'Roles_idRoles' => 'required|exists:roles,idRoles',
        ]);

        // Crear el nuevo usuario
        Usuario::create([
            'Nombres' => $request->Nombres,
            'Apellidos' => $request->Apellidos,
            'Documento' => $request->Documento,
            'Correo' => $request->Correo,
            'Contraseña' => Hash::make($request->Contraseña), // Hashear la contraseña
            'FechaDeNacimiento' => $request->FechaDeNacimiento,
            'token' => Str::random(40), // Generar un token único
            'Tipo_de_documento_idTipodedocumento' => $request->Tipo_de_documento_idTipodedocumento,
            'Roles_idRoles' => $request->Roles_idRoles,
        ]);

        // Redirigir con mensaje de éxito
        return redirect()->route('admin.usuario.index')->with('success', 'Usuario creado exitosamente');
    }

    // Mostrar el formulario para editar un usuario
    public function edit($id)
    {
        $usuario = Usuario::findOrFail($id);
        $tipos = TipoDeDocumento::all();
        $roles = Rol::all();

        return view('admin.usuario.edit', compact('usuario', 'tipos', 'roles'));
    }

    // Actualizar un usuario
    public function update(Request $request, $id)
    {
        // Validar los datos del formulario
        $request->validate([
            'Nombres' => 'required|string|max:45',
            'Apellidos' => 'required|string|max:45',
            'Documento' => 'required|string|max:35',
            'Correo' => 'required|string|email|max:100',
            'Contraseña' => 'nullable|string|min:8|confirmed',
            'FechaDeNacimiento' => 'required|date',
            'Tipo_de_documento_idTipodedocumento' => 'required|exists:tipo_de_documento,idTipodedocumento',
            'Roles_idRoles' => 'required|exists:roles,idRoles',
        ]);
    
        $usuario = Usuario::findOrFail($id);
    
        // Si la contraseña es proporcionada, la actualizamos
        $data = [
            'Nombres' => $request->Nombres,
            'Apellidos' => $request->Apellidos,
            'Documento' => $request->Documento,
            'Correo' => $request->Correo,
            'FechaDeNacimiento' => $request->FechaDeNacimiento,
            'Tipo_de_documento_idTipodedocumento' => $request->Tipo_de_documento_idTipodedocumento,
            'Roles_idRoles' => $request->Roles_idRoles,
        ];
    
        // Solo actualizamos la contraseña si no está vacía
        if ($request->Contraseña) {
            $data['Contraseña'] = bcrypt($request->Contraseña);
        }
    
        // Actualizar los datos del usuario
        $usuario->update($data);
    
        return redirect()->route('admin.usuario.index')->with('success', 'Usuario actualizado exitosamente');
    }
    

    // Eliminar un usuario
    public function destroy($id)
    {
        $usuario = Usuario::findOrFail($id);
        $usuario->delete();

        return redirect()->route('admin.usuario.index')->with('success', 'Usuario eliminado exitosamente');
    }
}
