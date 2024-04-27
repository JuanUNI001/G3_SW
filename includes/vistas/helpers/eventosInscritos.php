<?php
// Incluir las clases y archivos necesarios
require_once __DIR__.'/../../config.php';
use \es\ucm\fdi\aw\src\Eventos\Evento;
use \es\ucm\fdi\aw\src\Inscritos\Inscrito;
use \es\ucm\fdi\aw\src\Usuarios\Usuario;

// Función para mostrar los eventos inscritos
function mostrarEventosInscritos()
{
    // Comprobar si el usuario está logueado
    if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
        $rutaLogin = resuelve('/login.php');
        header("Location: $rutaLogin");
        exit();
    }

    // Obtener el correo del usuario logueado
    $correo_usuario = $_SESSION['correo'];

    // Buscar el usuario por su correo
    $usuario = Usuario::buscaUsuario($correo_usuario);
    $id_usuario = $usuario->getId();

    // Buscar los eventos inscritos por el usuario
    $eventosInscritos = Inscrito::buscarEventos($id_usuario);

    // Crear un array para almacenar los eventos
    $eventos = [];

    // Recorrer los eventos inscritos y obtener sus detalles
    foreach ($eventosInscritos as $idEvento) {
        $detallesEvento = Evento::buscaPorId($idEvento);
        if ($detallesEvento) {
            // Obtener los detalles del evento
            $nombreEvento = $detallesEvento->getEvento();
            $fecha = $detallesEvento->getFecha();
            // Agregar el evento al array de eventos
            $eventos[] = [
                'title' => $nombreEvento,
                'start' => $fecha
            ];
        }
    }

    // Convertir el array de eventos a formato JSON
    $eventosJson = json_encode($eventos);

    // Generar el contenido HTML con FullCalendar
    $contenidoPrincipal = <<<HTML
    <div id="calendar"></div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var eventos = $eventosJson;
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: []
            });
            calendar.render();
        });
    </script>
    HTML;

    // Devolver el contenido principal
    return $contenidoPrincipal;
}
?>
