<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evento;

class EventoController extends Controller
{
    public function index()
    {
        $eventos = Evento::orderBy('Fecha_Evento', 'asc')->get();
        return view('admin.eventos.index', compact('eventos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'fecha_evento' => 'required|date'
        ]);

        Evento::create([
            'Titulo' => $request->titulo,
            'Descripcion' => $request->descripcion,
            'Fecha_Evento' => $request->fecha_evento,
        ]);

        return redirect()->route('admin.eventos.index')->with('success', 'Evento agregado exitosamente.');
    }

    public function edit($id)
    {
        $evento = Evento::findOrFail($id);
        return view('admin.eventos.edit', compact('evento'));  // Retorna la vista con el evento
    }

    public function update(Request $request, $id)
    {
        $evento = Evento::findOrFail($id);

        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'fecha_evento' => 'required|date'
        ]);

        $evento->update([
            'Titulo' => $request->titulo,
            'Descripcion' => $request->descripcion,
            'Fecha_Evento' => $request->fecha_evento,
        ]);

        return redirect()->route('admin.eventos.index')->with('success', 'Evento actualizado correctamente.');
    }

    public function destroy($id)
    {
        $evento = Evento::findOrFail($id);
        $evento->delete();

        return redirect()->route('admin.eventos.index')->with('success', 'Evento eliminado exitosamente.');
    }
}
