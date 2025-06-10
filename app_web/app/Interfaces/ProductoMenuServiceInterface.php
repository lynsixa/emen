<?php

namespace App\Interfaces;

interface ProductoMenuServiceInterface
{
    public function obtenerDisponibles();
    public function buscarPorId(int $id);
}
