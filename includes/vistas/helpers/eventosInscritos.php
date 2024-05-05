<?php
require_once __DIR__.'/../../config.php';
use \es\ucm\fdi\aw\src\Inscritos\Inscrito;
use \es\ucm\fdi\aw\src\Usuarios\Usuario;
use  \es\ucm\fdi\aw\src\Eventos\Evento;

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
        foreach ($EventosInscritos as $inscrito) {
            // Obtener la información del evento inscrito
            $evento = [
                'title' => $inscrito->getTitle(), // Utiliza el título del evento
                'start' => $inscrito->getStart()->format('Y-m-d'), // Obtener la fecha de inicio del evento en el formato adecuado

            ];
            // Agregar el evento al array de eventos
            $eventos[] = $evento;
        }
    } else {
        // Manejar el caso en que no haya eventos inscritos
        $eventos[] = [
            'title' => 'No tienes eventos inscritos',
            'start' => date('Y-m-d'), // Puedes ajustar esta fecha según lo necesites
        ];
    }


    // Convertir el array de eventos a formato JSON
    return json_encode($eventos);
}


?>
