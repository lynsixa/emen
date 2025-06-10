<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table = 'roles'; // Nombre de la tabla en la base de datos
    protected $primaryKey = 'idRoles'; // Clave primaria
    public $timestamps = false; // No usamos created_at y updated_at
}
