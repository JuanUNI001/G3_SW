<?php
require_once 'includes/config.php';
require_once 'includes/vistas/helpers/eventosInscritos.php';

$tituloPagina = 'Eventos Inscritos';

// Obtener los eventos inscritos en formato JSON
$eventosJSON = mostrarEventosInscritos();

// Construir el contenido principal con el script de FullCalendar y el div con el id "calendar"
$contenidoPrincipal = <<<HTML
<div id="calendar" style="width: 1000px; height: 800px; font-size: 16px;"></div>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth', // Establecer la vista inicial como "mes"
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: '' // Eliminar las opciones de vista semanal y diaria
      },
      events: $eventosJSON // Pasar los eventos en formato JSON
    });
    calendar.render();
  });
</script>



HTML;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);
?>
