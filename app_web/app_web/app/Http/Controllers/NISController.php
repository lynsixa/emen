<?php

namespace App\Http\Controllers;

use App\Models\NIS;
use App\Models\Mesa;
use App\Models\Menu;
use App\Models\Evento;
use Illuminate\Http\Request;

class NISController extends Controller
{
    // Mostrar la lista de NIS
    public function index()
    {
        $nis = NIS::all();  // Obtener todos los NIS
        return view('admin.nis.index', compact('nis'));
    }

    // Mostrar el formulario para crear un nuevo NIS
    public function create()
    {
        // Obtener todas las mesas, menús y eventos
        $mesas = Mesa::all();
        $menus = Menu::all();
        $eventos = Evento::all();

        return view('admin.nis.create', compact('mesas', 'menus', 'eventos'));
    }

    // Guardar un nuevo NIS en la base de datos
    public function store(Request $request)
    {
        // Validación de los datos del formulario
        $request->validate([
            'descripcion' => 'required|string|max:100',
            'numero_piso' => 'required|integer',
            'numero_mesa' => 'required|integer',
            'menu_id' => 'required|exists:menu,idMenu', // Asegúrate que el menu_id sea válido
        ]);

        // Verificar si ya existe un NIS con la misma descripción, número de mesa y piso
        $existingNis = NIS::where('Descripcion', $request->descripcion)
                          ->whereHas('Mesa', function($query) use ($request) {
                              $query->where('NumeroPiso', $request->numero_piso)
                                    ->where('NumeroMesa', $request->numero_mesa);
                          })
                          ->first();

        if ($existingNis) {
            return redirect()->back()->withErrors('Ya existe un NIS con esa descripción y mesa.');
        }

        // Verificar si la mesa ya existe
        $mesa = Mesa::where('NumeroPiso', $request->numero_piso)
                    ->where('NumeroMesa', $request->numero_mesa)
                    ->first();

        if (!$mesa) {
            // Si la mesa no existe, crearla
            $mesa = Mesa::create([
                'NumeroPiso' => $request->numero_piso,
                'NumeroMesa' => $request->numero_mesa,
            ]);
        }

        // Crear el NIS
        NIS::create([
            'Descripcion' => $request->descripcion,
            'Mesa_idMesa' => $mesa->idMesa,  // Asociamos la mesa
            'Menu_idMenu' => $request->menu_id,  // Asociamos el menú
            'Eventos_idEventos' => $request->eventos_id, // Asociamos el evento (si existe)
            'Disponibilidad' => 1,  // Disponibilidad por defecto como 1 (está disponible)
        ]);

        // Redirigir al índice de NIS con un mensaje de éxito
        return redirect()->route('admin.nis.index')->with('success', 'NIS creado exitosamente');
    }

    // Mostrar el formulario para editar un NIS
    public function edit($id)
    {
        // Buscar el NIS usando la columna primaria correcta
        $nis = NIS::findOrFail($id);

        // Obtener todas las mesas, menús y eventos
        $mesas = Mesa::all();
        $menus = Menu::all();
        $eventos = Evento::all();

        return view('admin.nis.edit', compact('nis', 'mesas', 'menus', 'eventos'));
    }

    // Actualizar los datos de un NIS
    public function update(Request $request, $id)
    {
        // Validación de los datos del formulario
        $request->validate([
            'descripcion' => 'required|string|max:100|unique:codigonis,Descripcion,' . $id . ',idCodigoNis',  // Asegura que el código no se repita
            'numero_piso' => 'required|integer',
            'menu_id' => 'required|exists:menu,idMenu',
            'disponibilidad' => 'required|boolean',
        ]);

        // Buscar el NIS que se va a editar
        $nis = NIS::findOrFail($id);

        // Verificar si ya existe otro NIS con la misma descripción y mesa (en la base de datos)
        $existingNis = NIS::where('Descripcion', $request->descripcion)
                          ->where('Mesa_idMesa', $nis->Mesa_idMesa) // Aseguramos que sea el mismo ID de mesa
                          ->where('idCodigoNis', '!=', $id) // Aseguramos que no sea el mismo NIS
                          ->first();

        if ($existingNis) {
            return redirect()->back()->withErrors('Ya existe un NIS con esa descripción y mesa.');
        }

        // Buscar la mesa usando el número de piso del formulario y el número de mesa existente en el NIS
        $mesa = Mesa::where('NumeroPiso', $request->numero_piso)
                    ->where('NumeroMesa', $nis->Mesa->NumeroMesa) // Usamos el número de mesa actual
                    ->first();

        if (!$mesa) {
            return redirect()->back()->withErrors('La mesa no existe en la base de datos');
        }

        // Actualizar el NIS
        $nis->update([
            'Descripcion' => $request->descripcion,
            'Mesa_idMesa' => $mesa->idMesa,
            'Menu_idMenu' => $request->menu_id,
            'Eventos_idEventos' => $request->eventos_id,
            'Disponibilidad' => $request->disponibilidad,
        ]);

        // Redirigir al índice de NIS con un mensaje de éxito
        return redirect()->route('admin.nis.index')->with('success', 'NIS actualizado exitosamente');
    }

    // Eliminar un NIS
    public function destroy($id)
    {
        // Buscar el NIS que se va a eliminar
        $nis = NIS::findOrFail($id);
        
        // Eliminar el NIS
        $nis->delete();

        // Redirigir al índice de NIS con un mensaje de éxito
        return redirect()->route('admin.nis.index')->with('success', 'NIS eliminado exitosamente');
    }
}
