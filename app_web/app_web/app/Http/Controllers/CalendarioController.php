<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evento;

class CalendarioController extends Controller
{
    public function index()
    {
        return view('admin.calendario.index'); // Retorna la vista con el calendario
    }

    public function eventos(Request $request)
    {
        // Obtener las fechas de inicio y fin enviadas desde FullCalendar
        $start = $request->get('start');
        $end = $request->get('end');
    
        // Filtrar eventos según el rango de fechas
        $eventos = Evento::whereBetween('Fecha_Evento', [$start, $end])
                         ->select('idEventos as id', 'Titulo as title', 'Fecha_Evento as start', 'Descripcion as description')
                         ->get();
    
        return response()->json($eventos);
    }
    
}
