<?php
require_once __DIR__.'/../../config.php';
use \es\ucm\fdi\aw\src\Eventos\Evento;
use \es\ucm\fdi\aw\src\Inscritos\Inscrito;
use \es\ucm\fdi\aw\src\Usuarios\Usuario;

function mostrarEventosInscritos()
{
    if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
        $rutaLogin = resuelve('/login.php');
        header("Location: $rutaLogin");
        exit();
    }

    $correo_usuario = $_SESSION['correo'];

    $usuario = Usuario::buscaUsuario($correo_usuario);
    $id_usuario = $usuario->getId();

    $EventosInscritos = Inscrito::buscaTodosEventos($id_usuario);

    $eventos = [];

    if ($EventosInscritos) {
        foreach ($EventosInscritos as $idEvento) {
            $detallesEvento = Evento::buscaPorId($idEvento);
            if ($detallesEvento) {
                $nombreEvento = $detallesEvento->getEvento();
                $lugar = $detallesEvento->getLugar();
                $fecha = $detallesEvento->getFecha()->format('Y-m-d'); // Ajusta el formato según sea necesario
            
                // Construir un array asociativo con la información del evento
                $evento = [
                    'title' => $nombreEvento,
                    'start' => $fecha,
                    'location' => $lugar
                    // Puedes agregar más información del evento según lo necesites
                ];
            
                // Agregar el evento al array de eventos
                $eventos[] = $evento;
            }
        }
    }

    // Convertir el array de eventos a formato JSON
    $eventosJSON = json_encode($eventos);

    // Imprimir el JSON
    echo $eventosJSON;
}

?>
