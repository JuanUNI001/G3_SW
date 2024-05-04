<?php
require_once 'includes/config.php';
require_once 'includes/vistas/helpers/eventosInscritos.php';

$tituloPagina = 'Eventos Inscritos';

// Obtener el JSON de los eventos utilizando la función mostrarEventosInscritos()
$eventosJSON = mostrarEventosInscritos();


$contenidoPrincipal = <<<EOS
<script>
    $(document).ready(function() {
        var calendarEl = $('#calendar')[0];
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'timeGridWeek',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            // Pasar el JSON de los eventos al calendario
            events: $eventosJSON
        });
        calendar.render();
    });
</script>
EOS;

$params = ['tituloPagina' => $tituloPagina, 'contenidoPrincipal' => $contenidoPrincipal];
$app->generaVista('/plantillas/plantilla.php', $params);


?>
