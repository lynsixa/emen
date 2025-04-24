<!DOCTYPE html>
<html lang="es">
<head>
<<<<<<< HEAD
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Productos</title>

  <!-- Favicon y Bootstrap -->
  <link rel="icon" href="assets/img/log.png" type="image/png" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" />
  <link rel="stylesheet" href="assets/css/styleIndex.css" />

  <!-- Alerta PHP -->
  <script type="text/javascript">
    <?php
      if (isset($_GET['orden']) && $_GET['orden'] == 'exito') {
          echo "alert('¡Orden realizada con éxito!');";
      }
    ?>
  </script>
</head>
<body>

  <!-- Fondo rotativo -->
  <div class="fondo-rotativo">
    <img src="assets/img/IMG_5081.JPG" alt="Fondo 1">
    <img src="assets/img/DSC06494.jpg" alt="Fondo 2">
    <img src="assets/img/IMG_5105.JPG" alt="Fondo 3">
  </div>

  <!-- Encabezado -->
  <div class="d-flex justify-content-between align-items-center header-transparente shadow-sm px-4 py-3">
  <!-- Imagen del loco -->
  <div class="loco-img">
    <img src="assets/img/log.png" alt="Loco divertido" />
  </div>

  <!-- Botones -->
  <div class="d-flex gap-2 align-items-center">
=======
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"/>
    <link rel="stylesheet" type="text/css" href="assets/css/styleIndex.css">
    <script type="text/javascript">
        // Mostrar alerta si la orden fue realizada con éxito
        <?php
        if (isset($_GET['orden']) && $_GET['orden'] == 'exito') {
            echo "alert('¡Orden realizada con éxito!');";
        }
        ?>
    </script>
</head>
<body>
 <!-- Encabezado -->
 <div class="d-flex justify-content-end align-items-center gap-2 p-3 bg-white shadow-sm">
>>>>>>> d7ad886f3380c3d4559d10dc883980110ce673e6
    <a href="perfil.php" class="btn btn-outline-secondary" title="Ver perfil">
      <i class="bi bi-person-circle"></i>
    </a>
    <a href="ver_estado_producto.php" class="btn btn-outline-primary" title="Ver estado del producto">
<<<<<<< HEAD
      <i class="bi bi-eye"></i> Estado del Producto
    </a>
    <a href="../index.php" class="btn btn-custom">
      <i class="bi bi-arrow-left-circle"></i> Volver
    </a>
    <a href="/Proyecto/app_web/Controlador/cerrar_sesion.php" class="btn btn-danger">
      <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
    </a>
  </div>
</div>



  <!-- Contenido principal -->
  <div class="container mt-5">

    <!-- Video destacado -->
    <div class="row justify-content-center">
      <div class="col-lg-8 text-center mb-4">
        <div class="section_title">
          <video class="custom-video" autoplay loop playsinline controls>
            <source src="../gesProductos/fotosProductos/123.mp4" type="video/mp4" />
            Tu navegador no soporta la reproducción de video.
          </video>
        </div>
      </div>
    </div>

    <!-- Frase destacada -->
    <div class="row justify-content-center">
      <div class="col-lg-8 text-center mt-5">
        <div class="section_title quote-highlight">
          <h2>"Noches que iluminan el alma, recuerdos que viven para siempre."</h2>
        </div>
      </div>
    </div>

    <!-- Título productos -->
<h2 class="text-center fw-bold fs-4 titulo-blanco">Productos Disponibles</h2>


    <!-- Contenedor de productos -->
    <div id="productos-container" class="row justify-content-center">
      <div class="col-12 text-center">
        <p class="text-muted">Cargando productos...</p>
      </div>
    </div>

  </div>

  <!-- JS Bootstrap y Scripts personalizados -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <!-- JS para cargar productos -->
  <script>
    document.addEventListener("DOMContentLoaded", function () {
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

  <!-- Fondo rotativo JS -->
  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const imagenes = document.querySelectorAll('.fondo-rotativo img');
      let indice = 0;

      if (imagenes.length > 0) {
        imagenes[indice].classList.add('active');

        setInterval(() => {
          imagenes[indice].classList.remove('active');
          indice = (indice + 1) % imagenes.length;
          imagenes[indice].classList.add('active');
        }, 5000);
      }
    });
  </script>

=======
  <i class="bi bi-eye"></i> Estado del Producto
</a>

    <a href="../index.php" class="btn btn-custom">
      <i class="bi bi-arrow-left-circle"></i> Volver
    </a>
    <a href="/Proyecto/Controlador/cerrar_sesion.php" class="btn btn-danger">
      <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
    </a>
  </div>

  <div class="container mt-5">
  <!-- Título Principal -->
  <h1 class="text-center text-primary fw-bold mb-4">Bienvenidos</h1>

  <!-- Animación para el GIF -->
  <div class="row justify-content-center">
    <div class="col-lg-8 text-center mb-4">
      <div class="section_title">
        <img class="img-fluid rounded-3 shadow-lg" src="../gesProductos/fotosProductos/gif.gif" alt="gif" style="max-width: 100%; height: auto;">
      </div>
    </div>
  </div>

  <!-- Subtítulo animado -->
  <div class="row justify-content-center">
    <div class="col-lg-8 text-center mt-5">
      <div class="section_title">
        <h2 class="text-dark font-weight-bold fs-3">Noches que brillan, recuerdos que duran siempre.</h2>
      </div>
    </div>
  </div>

  <!-- Contenedor de productos -->
  <div class="row justify-content-center mb-4">
    <h2 class="text-center text-primary fs-4 fw-bold">Productos Disponibles</h2>
  </div>

  <div id="productos-container" class="row justify-content-center">
    <div class="col-12 text-center">
      <p class="text-muted">Cargando productos...</p>
    </div>
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
>>>>>>> d7ad886f3380c3d4559d10dc883980110ce673e6
</body>
</html>
