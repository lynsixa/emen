<?php
// Incluir el archivo de conexión
include_once 'Conexion.php';

// Crear la instancia de la clase Conexion
$conexion = new Conexion();
$conn = $conexion->getConnection(); // Obtener la conexión PDO

// Consultar los eventos de la base de datos
$query = "SELECT * FROM eventos ORDER BY fecha_evento ASC";
$resultado = $conn->query($query);

$eventos = [];
while ($evento = $resultado->fetch(PDO::FETCH_ASSOC)) { // Usar fetch(PDO::FETCH_ASSOC) para obtener un array asociativo
    // Formateamos los eventos en el formato que FullCalendar entiende
    $eventos[] = [
        'id' => $evento['idEvento'],
        'title' => $evento['titulo'],
        'start' => $evento['fecha_evento'],
        'description' => $evento['descripcion']
    ];
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
<link rel="stylesheet" href="cale.css">

    <meta charset="UTF-8">
    
    
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
