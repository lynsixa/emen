<?php

// app/Http/Controllers/SolicitudController.php

namespace App\Http\Controllers;

use App\Models\Solicitud;
use Illuminate\Http\Request;

class SolicitudController extends Controller
{
    // Mostrar las solicitudes pendientes y las despachadas/rechazadas
    public function index()
    {
        // Obtener todas las solicitudes que no han sido despachadas (Despachado = 0)
        $solicitudes = Solicitud::where('Despachado', 0)->get();

        // Obtener todas las solicitudes que han sido despachadas o rechazadas
        $ordenesEntregadas = Solicitud::whereIn('Despachado', [1, -1])->get();

        // Pasar las solicitudes pendientes y las entregadas a la vista
        return view('bartender.index', compact('solicitudes', 'ordenesEntregadas'));
    }

    // Despachar una solicitud
    public function despachar(Request $request)
    {
        // Buscar la solicitud por id
        $solicitud = Solicitud::findOrFail($request->id);
        
        // Marcar como despachada (Despachado = 1)
        $solicitud->update(['Despachado' => 1]);

        // Redirigir de vuelta con un mensaje de éxito
        return redirect()->route('Bartender.index')->with('despachado', true);
    }

    // Rechazar una solicitud
    public function rechazar(Request $request)
    {
        // Validar el motivo para asegurarse de que no esté vacío
        $request->validate([
            'motivo' => 'required|string|max:500',
        ]);

        // Buscar la solicitud por id
        $solicitud = Solicitud::findOrFail($request->id);

        // Actualizar los campos 'Despachado' y 'Informe'
        $solicitud->update([
            'Despachado' => -1,  // Marcar como rechazada
            'Informe' => \Illuminate\Support\Str::finish($solicitud->Informe, "\nMotivo: {$request->motivo}") // Concatenar motivo al informe
        ]);

        // Redirigir de vuelta con un mensaje de éxito
        return redirect()->route('Bartender.index')->with('rechazado', true);
    }
}
