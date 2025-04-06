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
        <h1 class="text-center text-primary">Bienvenido a Emen</h1>

        <div class="row align-items-center">
				<div class="col-lg-12 text-center">
					<div class="section_title">
						<img class="img-fluid" src="../gesProductos/fotosProductos/gif.gif" alt="gif">
					</div>
				</div>
			</div>

			<div class="row align-items-center">
				<div class="col-lg-12 text-center mt-5">
					<div class="section_title">
						<h2>Noches que brillan, recuerdos que duran siempre.</h2>
					</div>
				</div>
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
