<?php

namespace App\Http\Controllers;

use App\Interfaces\OrdenServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrdenController extends Controller
{
    private $ordenService;

    public function __construct(OrdenServiceInterface $ordenService)
    {
        $this->ordenService = $ordenService;
    }

    public function index()
    {
        return response()->json($this->ordenService->obtenerTodas());
    }

    public function show($id)
    {
        return response()->json($this->ordenService->obtenerPorId($id));
    }

    public function store(Request $request)
    {
        $orden = $this->ordenService->crear($request->all());
        return response()->json($orden, 201);
    }

    public function update(Request $request, $id)
    {
        $orden = $this->ordenService->actualizar($id, $request->all());
        return response()->json($orden);
    }

    public function destroy($id)
    {
        $this->ordenService->eliminar($id);
        return response()->json(['mensaje' => 'Orden eliminada correctamente']);
    }

    /**
     * Guarda una orden a partir de los productos del carrito.
     */
public function guardarDesdeCarrito(Request $request)
{
    $carrito = json_decode($request->input('carrito'), true);

    if (empty($carrito)) {
        return response()->json(['error' => 'El carrito está vacío.'], 400);
    }

    // Puedes usar usuario 0 o uno ficticio si no hay login
    $usuarioId = 0;

    $this->ordenService->crearOrdenDesdeCarrito($carrito, $usuarioId);

    return response()->json(['mensaje' => 'Orden generada correctamente']);
}


}

    

