<?php

namespace App\Http\Controllers\Usuarios;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\CodigoNis; // Asegúrate de tener este modelo si usas BD para menú

class CodigoNisController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Session::has('idUsuario')) {
                return redirect()->route('login');
            }
            return $next($request);
        });
    }

    public function index()
    {
        if (Session::has('codigo')) {
            return redirect()->route('usuarios.codigonis.indexscan');
        }
        return view('usuarios.codigonis.index');
    }

    public function validarCodigo(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string',
        ]);

        $codigoIngresado = $request->codigo;

        $codigo = CodigoNis::where('Descripcion', $codigoIngresado)->first();

        if (!$codigo) {
            return back()->with('mensaje', 'Código no existe');
        }

        if ($codigo->Disponibilidad == 0) {
            return back()->with('mensaje', 'Código ya utilizado, no puede ingresar');
        }

        // Marcar código como usado
        $codigo->Disponibilidad = 0;
        $codigo->save();

        // Guardar en sesión
        Session::put('codigo', $codigoIngresado);
        Session::put('numeroMesa', $codigo->Mesa_idMesa);
        Session::put('numeroPiso', $codigo->Eventos_idEventos ?? 'No disponible');

        // Si tienes relación para obtener descripción menú, la obtienes aquí
        // Por ahora simulamos:
        $menuDescripcion = "Menú ejemplo"; // Reemplaza con lógica real si tienes modelo relacionado

        Session::put('menuDescripcion', $menuDescripcion);

        return redirect()->route('usuarios.codigonis.indexscan');
    }

    public function indexScan()
    {
        $numeroMesa = Session::get('numeroMesa', 'No disponible');
        $numeroPiso = Session::get('numeroPiso', 'No disponible');
        $menuDescripcion = Session::get('menuDescripcion', 'No disponible');

        return view('usuarios.codigonis.indexscan', compact('numeroMesa', 'numeroPiso', 'menuDescripcion'));
    }

    public function cerrarSesion()
    {
        Session::flush();
        return redirect()->route('login');
    }
}
