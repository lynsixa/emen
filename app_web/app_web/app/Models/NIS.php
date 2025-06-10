<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NIS extends Model
{
    protected $table = 'codigonis';
    protected $primaryKey = 'idCodigoNis';
    public $timestamps = true;

    protected $fillable = [
        'Descripcion', 
        'Mesa_idMesa', 
        'Menu_idMenu', 
        'Eventos_idEventos', 
        'Disponibilidad'
    ];

    // Relación con Mesa
    public function mesa()
    {
        return $this->belongsTo(Mesa::class, 'Mesa_idMesa', 'idMesa'); // Asegúrate de que las claves coincidan
    }

    // Relación con Menu
    public function menu()
    {
        return $this->belongsTo(Menu::class, 'Menu_idMenu', 'idMenu');
    }

    // Relación con Evento
    public function evento()
    {
        return $this->belongsTo(Evento::class, 'Eventos_idEventos', 'idEventos');
    }
}
