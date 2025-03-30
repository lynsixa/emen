<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Verificar si el parámetro 'orden' en la URL es igual a 'exito'
            const urlParams = new URLSearchParams(window.location.search);
            const orden = urlParams.get('orden');

            // Si la orden fue exitosa, mostrar la alerta
            if (orden === 'exito') {
                alert("¡Tu orden se ha realizado con éxito!");
            }

            // Cargar los productos
            fetch("productos.php")
                .then(response => response.json())
                .then(data => {
                    let contenedor = document.getElementById("productos-container");
                    contenedor.innerHTML = ""; // Limpiar antes de agregar productos
                    
                    data.forEach(producto => {
                        let productoHTML = `
                            <div class="producto">
                                <img src="${producto.Foto1}" alt="${producto.Nombre}">
                                <h3>${producto.Nombre}</h3>
                                <p>Precio: $${parseFloat(producto.Precio).toFixed(2)}</p>
                                <button onclick="window.location.href='detalles_producto.php?idProducto=${producto.idProducto}'">
                                    Agregar al carrito
                                </button>
                            </div>
                        `;
                        contenedor.innerHTML += productoHTML;
                    });
                })
                .catch(error => console.error("Error al cargar productos:", error));
        });
    </script>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
        }
        .contenedor {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            margin: 20px;
        }
        .producto {
            width: 250px;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 2px 2px 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        .producto img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 5px;
        }
        .producto h3 {
            font-size: 18px;
            margin: 10px 0;
        }
        .producto p {
            font-size: 16px;
            color: #555;
        }
        .producto button {
            background-color: #28a745;
            color: white;
            padding: 10px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }
        .producto button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

    <h1>Productos Disponibles</h1>
    <div id="productos-container" class="contenedor">
        <p>Cargando productos...</p>
    </div>

</body>
</html>
