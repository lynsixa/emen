<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="assets/css/styleIndex.css">
</head>
<body>
    <div class="container mt-4">
        <h1 class="text-center text-primary">Bienvenido a Nuestra Tienda</h1>

        <!-- Carrusel de imágenes -->
        <div id="carouselExample" class="carousel slide mb-4" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="img/banner1.jpg" class="d-block w-100" alt="Promoción 1">
                </div>
                <div class="carousel-item">
                    <img src="img/banner2.jpg" class="d-block w-100" alt="Promoción 2">
                </div>
                <div class="carousel-item">
                    <img src="img/banner3.jpg" class="d-block w-100" alt="Promoción 3">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Anterior</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Siguiente</span>
            </button>
        </div>

        <!-- Contenedor de productos -->
        <h2 class="text-center text-primary">Productos Disponibles</h2>
        <div id="productos-container" class="row justify-content-center">
            <p class="text-center">Cargando productos...</p>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            fetch("productos.php")
                .then(response => response.json())
                .then(data => {
                    let contenedor = document.getElementById("productos-container");
                    contenedor.innerHTML = ""; 

                    if (data.length === 0) {
                        contenedor.innerHTML = "<p class='text-center text-danger'>No hay productos disponibles.</p>";
                        return;
                    }

                    data.forEach(producto => {
                        let productoHTML = `
                            <div class="col-md-4 mb-4">
                                <div class="card product-card shadow-sm">
                                    <img src="${producto.Foto1}" class="card-img-top" alt="${producto.Nombre}">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">${producto.Nombre}</h5>
                                        <p class="card-text fw-bold text-success">Precio: $${parseFloat(producto.Precio).toFixed(2)}</p>
                                        <a href='detalles_producto.php?idProducto=${producto.idProducto}' class="btn btn-primary">Agregar al carrito</a>
                                    </div>
                                </div>
                            </div>
                        `;
                        contenedor.innerHTML += productoHTML;
                    });
                })
                .catch(error => {
                    document.getElementById("productos-container").innerHTML = "<p class='text-danger text-center'>Error al cargar los productos. Inténtalo de nuevo.</p>";
                });
        });
    </script>
</body>
</html>
