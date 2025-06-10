<?php

namespace App\Http\Controllers;

use App\Interfaces\ProductoMenuServiceInterface;
use App\Services\CarritoService;
use Illuminate\Http\Request;
use App\Models\Producto;

class MenuController extends Controller
{
    protected ProductoMenuServiceInterface $productoMenuService;
    protected CarritoService $carritoService;

    public function __construct(
        ProductoMenuServiceInterface $productoMenuService,
        CarritoService $carritoService
    ) {
        $this->productoMenuService = $productoMenuService;
        $this->carritoService = $carritoService;
    }

 public function index()
{
    $productos = Producto::with('categoria')->get();
    $carritoOriginal = session('carrito', []);

    // Convertir a un array plano para evitar errores con @json
    $carrito = array_map(function ($item) {
        return [
            'producto' => [
                'idProducto' => $item['producto']->idProducto,
                'Precio' => $item['producto']->Precio,
                'categoria' => [
                    'Nombre' => $item['producto']->categoria->Nombre ?? '',
                ],
            ],
            'cantidad' => $item['cantidad'],
        ];
    }, $carritoOriginal);

    return view('cliente.menu.index', compact('productos', 'carrito'));
}


    public function agregar(Request $request)
    {
        $producto = $this->productoMenuService->buscarPorId($request->input('producto_id'));

        if (!$producto) {
            return back()->with('error', 'Producto no encontrado.');
        }

        $this->carritoService->agregarProducto($producto, (int) $request->input('cantidad', 1));

        return back()->with('success', 'Producto agregado al carrito.');
    }
    public function eliminarDelCarrito($productoId)
{
    $this->carritoService->eliminarProducto((int) $productoId);
    return back()->with('success', 'Producto eliminado del carrito.');
}

public function vaciarCarrito()
{
    $this->carritoService->vaciarCarrito();
    return back()->with('success', 'Carrito vaciado correctamente.');
    
}

}
