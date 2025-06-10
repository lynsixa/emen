<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::with('categoria')->get();
        return view('admin.producto.index', compact('productos'));
    }

    public function create()
    {
        return view('admin.producto.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'precio' => 'required|numeric|max:9999999.999',
            'cantidad' => 'required|integer',
            'nombre_categoria' => 'required|string',
            'descripcion' => 'required|string',
            'imagen1' => 'required|image',
            'imagen2' => 'nullable|image',
            'imagen3' => 'nullable|image',
        ]);

        DB::beginTransaction();

        try {
            $producto = Producto::create([
                'Precio' => $request->precio,
                'Disponibilidad' => $request->cantidad > 0 ? 1 : 0,
                'Cantidad' => $request->cantidad,
                'CodigoNis_idCodigoNis' => null,
                'Categoria_idCategoria' => null,
            ]);

            $imagenes = [];
            $carpeta = public_path('fotosProductos/');

            for ($i = 1; $i <= 3; $i++) {
                $archivo = $request->file("imagen$i");
                if ($archivo) {
                    $nombre = time() . "_img{$i}_" . $archivo->getClientOriginalName();
                    $archivo->move($carpeta, $nombre);
                    $imagenes[] = $nombre;
                } else {
                    $imagenes[] = null;
                }
            }

            $categoria = Categoria::create([
                'Nombre' => $request->nombre_categoria,
                'Descripcion' => $request->descripcion,
                'Foto1' => $imagenes[0],
                'Foto2' => $imagenes[1],
                'Foto3' => $imagenes[2],
                'Producto_idProducto' => $producto->idProducto,
            ]);
            
            $producto->Categoria_idCategoria = $categoria->idCategoria;
            $producto->save();
            
            DB::commit();

            return redirect()->route('admin.producto.index')->with('success', 'Producto creado correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors('Error al crear producto: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $producto = Producto::with('categoria')->findOrFail($id);
        return view('admin.producto.edit', compact('producto'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'precio' => 'required|numeric|max:9999999.999',
            'cantidad' => 'required|integer',
            'nombre_categoria' => 'required|string',
            'descripcion' => 'required|string',
            'imagen1' => 'nullable|image',
            'imagen2' => 'nullable|image',
            'imagen3' => 'nullable|image',
        ]);

        $producto = Producto::findOrFail($id);
        $producto->update([
            'Precio' => $request->precio,
            'Cantidad' => $request->cantidad,
            'Disponibilidad' => $request->cantidad > 0 ? 1 : 0,
        ]);

        $categoria = $producto->categoria;
        $imagenes = [$categoria->Foto1, $categoria->Foto2, $categoria->Foto3];
        $carpeta = public_path('fotosProductos/');

        for ($i = 1; $i <= 3; $i++) {
            $archivo = $request->file("imagen$i");
            if ($archivo) {
                $nombre = time() . "_img{$i}_" . $archivo->getClientOriginalName();
                $archivo->move($carpeta, $nombre);
                $imagenes[$i - 1] = $nombre;
            }
        }

        $categoria->update([
            'Nombre' => $request->nombre_categoria,
            'Descripcion' => $request->descripcion,
            'Foto1' => $imagenes[0],
            'Foto2' => $imagenes[1],
            'Foto3' => $imagenes[2],
        ]);

        return redirect()->route('admin.producto.index')->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);

        if ($producto->categoria) {
            $producto->categoria->delete();
        }

        $producto->delete();

        return redirect()->route('admin.producto.index')->with('success', 'Producto eliminado correctamente.');
    }
}
