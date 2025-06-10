<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    // Mostrar todos los roles
    public function index()
    {
        $roles = Role::all();  // Obtener todos los roles
        return view('admin.roles.index', compact('roles'));
    }

    // Mostrar formulario para editar un rol
    public function edit($id)
    {
        $role = Role::findOrFail($id); // Encontrar el rol
        return view('admin.roles.edit', compact('role'));
    }

    // Actualizar el rol
    public function update(Request $request, $id)
    {
        $request->validate([
            'Descripcion' => 'required|string|max:100|unique:roles,Descripcion,' . $id . ',idRoles', // Asegura que el rol no se repita
        ]);

        $role = Role::findOrFail($id); // Buscar el rol a actualizar
        $role->update([
            'Descripcion' => $request->Descripcion, // Actualizar la descripción del rol
        ]);

        return redirect()->route('admin.roles.index')->with('success', 'Rol actualizado exitosamente');
    }

    // Eliminar un rol
    public function destroy($id)
    {
        $role = Role::findOrFail($id); // Buscar el rol
        $role->delete(); // Eliminar el rol

        return redirect()->route('admin.roles.index')->with('success', 'Rol eliminado exitosamente');
    }
}
