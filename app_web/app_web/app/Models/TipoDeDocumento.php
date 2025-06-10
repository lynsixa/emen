<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoDeDocumento extends Model
{
    protected $table = 'tipo_de_documento'; // Nombre de la tabla en la base de datos
    protected $primaryKey = 'idTipodedocumento'; // Clave primaria
    public $timestamps = false; // No usamos created_at y updated_at
}
