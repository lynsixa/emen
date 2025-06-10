<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    protected $table = 'eventos';
    protected $primaryKey = 'idEventos';
    public $timestamps = false; // La tabla no usa created_at ni updated_at

    protected $fillable = [
        'Titulo',
        'Descripcion',
        'Fecha_Evento',
    ];
}
