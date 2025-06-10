<?php

namespace App\Services;

use App\Models\Orden;
use App\Interfaces\OrdenServiceInterface;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrdenService implements OrdenServiceInterface
{
    public function obtenerTodas()
    {
        return Orden::all();
    }

    public function obtenerPorId($id)
    {
        return Orden::findOrFail($id);
    }

    public function crear(array $datos)
    {
        return Orden::create($datos);
    }

    public function actualizar($id, array $datos)
    {
        $orden = Orden::findOrFail($id);
        $orden->update($datos);
        return $orden;
    }

    public function eliminar($id)
    {
        $orden = Orden::findOrFail($id);
        return $orden->delete();
    }

    /**
     * Crear una o más órdenes desde los datos del carrito.
     *
     * @param array $carrito Lista de productos en el carrito.
     * @param int $usuarioId ID del usuario autenticado.
     */
    public function crearOrdenDesdeCarrito(array $carrito, int $usuarioId = null): void
{
    DB::transaction(function () use ($carrito, $usuarioId) {
        foreach ($carrito as $item) {
            $producto = $item['producto'];
            $cantidad = $item['cantidad'];

            // Asegurarse que se accede correctamente a nombre de categoría
            $descripcion = isset($producto['categoria']['Nombre']) 
                ? $producto['categoria']['Nombre'] 
                : 'Sin descripción';

            Orden::create([
                'TokenCliente' => uniqid('cliente_'),
                'Descripcion' => $descripcion,
                'PrecioFinal' => $producto['Precio'] * $cantidad,
                'Fecha' => Carbon::now(),
                'Producto_idProducto' => $producto['idProducto'],
                'Solicitud_idSolicitud' => null,
                'cantidad' => $cantidad,
                'Usuario_idUsuario' => $usuarioId,
            ]);
        }
    });
}
}
