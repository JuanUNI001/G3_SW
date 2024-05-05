<?php
require_once __DIR__.'/../../config.php';
use \es\ucm\fdi\aw\src\Eventos\Evento;
use \es\ucm\fdi\aw\src\Inscritos\Inscrito;
use \es\ucm\fdi\aw\src\Usuarios\Usuario;
function mostrarEventosInscritosSinCal()
{

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {

    $rutaLogin = resuelve('/login.php');
    header("Location: $rutaLogin");
    exit();
}
$tituloPagina = 'Eventos Inscritos';
$correo_usuario = $_SESSION['correo'];

$usuario = Usuario::buscaUsuario($correo_usuario);
$id_usuario = $usuario->getId();

$EventosInscritos = Inscrito::buscaTodosEventos($id_usuario);

if ($EventosInscritos) {
    $contenidoPrincipal = '';
    foreach ($EventosInscritos as $Evento) {
        $idEvento = $Evento->getId();
        $detallesEvento = Evento::buscaPorId($idEvento);
        if ($detallesEvento) {
            $nombreEvento = $detallesEvento->getEvento();
            $lugar = $detallesEvento->getLugar();
            $fecha = $detallesEvento->getFecha()->format('Y-m-d H:i:s');
            $contenidoPrincipal .= '<div class="evento">';
                $contenidoPrincipal .= '<div class="evento_info">';
                $contenidoPrincipal .= '<div class="evento_titulo">' . $nombreEvento . '</div>';
                $contenidoPrincipal .= '<div class="evento_contenido">';
                $contenidoPrincipal .= '<p><strong>Lugar:</strong> ' . $lugar . '</p>';
                $contenidoPrincipal .= '<p><strong>Fecha:</strong> ' . $fecha . '</p>';
                $contenidoPrincipal .= '</div>';
                $contenidoPrincipal .= '<form action="' . resuelve('/desinscribirseEvento.php') .'?id='.$idEvento . '" method="POST">';
                $contenidoPrincipal .= '<button type="submit" class="sideBarDerButton">Salir</button>';
                $contenidoPrincipal .= '</div>'; 
                $contenidoPrincipal .= '</div>'; 


        }
    }
} else {
    $contenidoPrincipal = "No tienes eventos inscritos";
}
return $contenidoPrincipal;


}