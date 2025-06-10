<?php

// app/Models/CodigoNis.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CodigoNis extends Model
{
    protected $table = 'codigonis';

    protected $primaryKey = 'idCodigoNis';

    public $timestamps = true;

    protected $fillable = [
        'Descripcion',
        'Disponibilidad',
        'Menu_idMenu',
        'Mesa_idMesa',
        'Eventos_idEventos',
    ];
}
