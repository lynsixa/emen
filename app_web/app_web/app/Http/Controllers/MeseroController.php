<?php
// app/Http/Controllers/MeseroController.php

namespace App\Http\Controllers;

use App\Models\Entrega;
use Illuminate\Http\Request;

class MeseroController extends Controller
{
    // Mostrar las entregas pendientes
    public function index()
    {
        // Obtener las entregas que aún no se han entregado y que han sido despachadas
        $entregas = Entrega::where('Entregado', 0)
            ->whereHas('solicitud', function ($query) {
                $query->where('Despachado', 1);  // Asegurarse de que la solicitud ha sido despachada
            })
            ->get();

        // Obtener las entregas que ya han sido entregadas o rechazadas
        $entregadas_y_rechazadas = Entrega::whereIn('Entregado', [1, -1])->get();  // Buscar entregadas y rechazadas

        return view('mesero.index', compact('entregas', 'entregadas_y_rechazadas'));
    }

    // Acción para entregar la orden
    public function entregar(Request $request)
    {
        // Asegurarse de que 'idEntrega' se esté pasando correctamente
        $entrega = Entrega::findOrFail($request->idEntrega);  // Buscar por 'idEntrega', no 'id'

        // Marcar la entrega como entregada
        $entrega->update(['Entregado' => 1]);

        // Redirigir con mensaje de éxito
        return redirect()->route('mesero.index')->with('entregada', 'Orden entregada correctamente');
    }

    // Acción para rechazar la orden
    public function rechazar(Request $request)
    {
        // Validar el motivo de rechazo
        $request->validate([
            'motivo' => 'required|string|max:250',  // Validación para asegurarse de que no exceda los 250 caracteres
        ]);

        // Buscar la entrega por ID
        $entrega = Entrega::findOrFail($request->idEntrega);

        // Verificar si la orden ya ha sido entregada o rechazada
        if ($entrega->Entregado == 1 || $entrega->Entregado == -1) {
            return redirect()->route('mesero.index')->with('error', 'No se puede rechazar esta orden. Ya ha sido entregada o rechazada.');
        }

        // Actualizar el estado de la entrega como rechazada y agregar el informe
        $entrega->update([
            'Informe' => $request->motivo,  // Almacenar el motivo de rechazo
            'Entregado' => -1,  // -1 significa rechazada
        ]);

        // Redirigir con mensaje de éxito
        return redirect()->route('mesero.index')->with('rechazada', 'Orden rechazada correctamente');
    }
}
