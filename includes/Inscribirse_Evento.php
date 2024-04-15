<?php
require_once 'config.php';

use \es\ucm\fdi\aw\src\Eventos\Evento;
use \es\ucm\fdi\aw\src\Inscritos\Inscrito;
use \es\ucm\fdi\aw\src\Usuarios\Usuario;
use es\ucm\fdi\aw\src\BD;

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    $dir = resuelve('/login.php');
    header("Location: $dir");
    exit();
}

$idE = $_POST['idEvento'] ?? null;
$app = BD::getInstance();
if ($idE) {

    $Evento = Evento::buscaPorId($idE);
    if (!$Evento) {

        $url = resuelve('/includes/src/Eventos/caracteristicaEvento.php') . '?idEvento=' . $idE;
        header("Location: $url");
        $mensajes = ['Ha hebido un error al inscribirte'];
       
    }
    else{
        $correo_usuario = $_SESSION['correo'];

        $usuario = Usuario::buscaUsuario($correo_usuario);

        if ($usuario) {
            $id_usuario = $usuario->getId();
        } else {
            $url = resuelve('/index.php');
            header("Location: $url");
            exit();
        }

        $inscripcion = Inscrito::inscribirUsuarioEnEvento($id_usuario, $idE);

        if ($inscripcion) {
            $mensajes = ['Te has inscrito al evento!'];
        }
    
        $url = resuelve('/includes/src/Eventos/caracteristicaEvento.php') . '?id_producto=' . $id_producto;
        header("Location: $url" );
    }
} else {
    
    $mensajes = ['Parece que algo ha salido mal :('];
    
   
    $url = resuelve('/tienda.php');
    header("Location: $url");
}
$app->putAtributoPeticion('mensajes', $mensajes);
exit();
?>
