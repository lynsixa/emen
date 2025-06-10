<?php
// Incluir el archivo de conexión
include_once 'conexion.php';

// Consultar los eventos de la base de datos
$query = "SELECT * FROM Eventos ORDER BY Fecha_Evento ASC"; // Asegúrate de que el nombre de la columna sea correcto
$resultado = $conn->query($query);

$eventos = [];
while ($evento = $resultado->fetch_assoc()) { // Usar fetch_assoc() para obtener un array asociativo
    // Formateamos los eventos en el formato que FullCalendar entiende
    $eventos[] = [
        'id' => $evento['idEventos'],  // Corrige el nombre de la columna
        'title' => $evento['Titulo'],  // Corrige el nombre de la columna
        'start' => $evento['Fecha_Evento'],  // Corrige el nombre de la columna
        'description' => $evento['Descripcion']  // Corrige el nombre de la columna
    ];
}

// Comprobar si la solicitud es de tipo API (por ejemplo, se hace desde Postman)
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['api'])) {
    // Si la solicitud es de tipo GET con el parámetro 'api', devolvemos los eventos en formato JSON
    header('Content-Type: application/json');
    echo json_encode($eventos);
    exit; // Finalizamos la ejecución del script, ya que solo queremos devolver los datos JSON
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Calendario de Eventos</title>
    <link rel="stylesheet" href="cale.css">
    <link rel="icon" type="image/png" href="../Admin/imagenes/log.png">
    <!-- FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.2/main.min.css" rel="stylesheet">
    
    <!-- jQuery (necesario para FullCalendar) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- FullCalendar JS -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.2/main.min.js"></script>

    <!-- Incluir el archivo de idioma en español para FullCalendar -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.2/locales/es.js"></script>

    <style>
        #calendar {
            max-width: 900px;
            margin: 0 auto;
            min-height: 600px;  /* Asegura que el calendario tenga altura */
        }
        
        /* Personalización para mostrar la descripción debajo del título */
        .fc-event-title {
            font-weight: bold;
        }

        .fc-event-description {
            font-size: 12px;
            color: #555;
        }
        .btn-volver {
    position: fixed;
    top: 20px;
    left: 20px;
    z-index: 999;
   }
    </style>
</head>
<body>


<!-- Mostrar el calendario -->
<div id="calendar"></div>

<script>
    $(document).ready(function() {
        // Inicializar el calendario FullCalendar
        var calendar = new FullCalendar.Calendar($('#calendar')[0], {
            locale: 'es', // Configurar el idioma a español
            events: <?php echo json_encode($eventos); ?>, // Pasamos los eventos desde PHP a JavaScript
            eventRender: function(info) {
                // Personalizamos el renderizado de los eventos para mostrar la descripción
                var description = info.event.extendedProps.description;
                
                // Agregar la descripción debajo del título
                var descriptionElement = $('<div class="fc-event-description">' + description + '</div>');
                $(info.el).append(descriptionElement);
            },
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            }
        });

        // Renderizar el calendario
        calendar.render();
    });
</script>

</body>
</html>
