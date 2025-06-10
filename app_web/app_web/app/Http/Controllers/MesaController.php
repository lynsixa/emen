<?php
namespace App\Http\Controllers;

use App\Models\Mesa;
use Illuminate\Http\Request;

class MesaController extends Controller
{
    // Muestra todas las mesas
    public function index()
    {
        $mesas = Mesa::all(); // Obtiene todas las mesas
        return view('admin.mesas.index', compact('mesas'));
    }

    // Crea una nueva mesa
    public function store(Request $request)
    {
        $request->validate([
            'NumeroPiso' => 'required|integer',
            'NumeroMesa' => 'required|integer',
        ]);

        // Crear la nueva mesa
        Mesa::create([
            'NumeroPiso' => $request->NumeroPiso,
            'NumeroMesa' => $request->NumeroMesa,
        ]);

        // Redirige al listado de mesas con mensaje de éxito
        return redirect()->route('admin.mesas.index')->with('success', 'Mesa creada con éxito.');
    }

    // Muestra el formulario para editar una mesa
    public function edit($id)
    {
        $mesa = Mesa::findOrFail($id); // Encuentra la mesa por su id
        return view('admin.mesas.edit', compact('mesa'));
    }

    // Actualiza la mesa
    public function update(Request $request, $id)
    {
        $request->validate([
            'NumeroPiso' => 'required|integer',
            'NumeroMesa' => 'required|integer',
        ]);

        $mesa = Mesa::findOrFail($id); // Encuentra la mesa por su id

        $mesa->update([
            'NumeroPiso' => $request->NumeroPiso,
            'NumeroMesa' => $request->NumeroMesa,
        ]);

        // Redirige al listado de mesas con mensaje de éxito
        return redirect()->route('admin.mesas.index')->with('success', 'Mesa actualizada con éxito.');
    }

    // Elimina una mesa
    public function destroy($id)
    {
        $mesa = Mesa::findOrFail($id); // Encuentra la mesa por su id
        $mesa->delete();

        // Redirige al listado de mesas con mensaje de éxito
        return redirect()->route('admin.mesas.index')->with('success', 'Mesa eliminada con éxito.');
    }
}
