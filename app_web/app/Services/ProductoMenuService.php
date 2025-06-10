<?php

namespace App\Services;

use App\Interfaces\ProductoMenuServiceInterface;
use App\Models\Producto;

class ProductoMenuService implements ProductoMenuServiceInterface
{
    public function obtenerDisponibles()
    {
        return Producto::with('categoria')
            ->where('Disponibilidad', 1)
            ->get();
    }

    public function buscarPorId(int $id)
    {
        return Producto::with('categoria')->find($id);
    }
}
