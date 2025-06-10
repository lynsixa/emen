@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Menú</h1>

    <div class="row">
        @foreach($productos as $producto)
        <div class="col-md-4">
            <div class="card mb-3">
                <img src="{{ asset('fotosProductos/' . $producto->categoria->Foto1) }}" class="card-img-top" alt="Producto">
                <div class="card-body">
                    <h5 class="card-title">{{ $producto->categoria->Nombre }}</h5>
                    <p>{{ $producto->categoria->Descripcion }}</p>
                    <p><strong>${{ $producto->Precio }}</strong></p>
                    <form method="POST" action="{{ route('menu.agregar') }}">
                        @csrf
                        <input type="hidden" name="producto_id" value="{{ $producto->idProducto }}">
                        <input type="number" name="cantidad" value="1" min="1" class="form-control mb-2">
                        <button class="btn btn-primary">Agregar al carrito</button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <h2 class="mt-4">Carrito de Compras</h2>
    @if(empty($carrito))
        <p>El carrito está vacío.</p>
    @else
        <ul class="list-group mb-3">
            @foreach($carrito as $item)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    {{ $item['producto']['categoria']['Nombre'] }} x {{ $item['cantidad'] }}
                    <form action="{{ route('menu.eliminar', $item['producto']['idProducto']) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Eliminar</button>
                    </form>
                </li>
            @endforeach
        </ul>

        <form action="{{ route('menu.vaciar') }}" method="POST" class="mb-3">
            @csrf
            @method('DELETE')
            <button class="btn btn-warning">Vaciar carrito</button>
        </form>

        <form method="POST" action="{{ route('orden.guardarDesdeCarrito') }}" onsubmit="return enviarOrden(event)">
            @csrf
            <input type="hidden" name="carrito" id="carrito-json">
            <button type="submit" class="btn btn-success">Generar Orden</button>
        </form>
    @endif

    @if(session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger mt-3">
            {{ session('error') }}
        </div>
    @endif
</div>

<<script>
    document.addEventListener("DOMContentLoaded", function () {
        const form = document.querySelector("form[action='{{ route('orden.guardarDesdeCarrito') }}']");
        if (form) {
            form.addEventListener("submit", function (event) {
                const carrito = {!! json_encode($carrito) !!};
                document.getElementById('carrito-json').value = JSON.stringify(carrito);
            });
        }
    });
</script>

@endsection
