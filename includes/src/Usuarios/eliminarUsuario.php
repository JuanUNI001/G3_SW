<?php
require_once __DIR__.'/../../config.php';
require_once  __DIR__.'/../Eventos/eliminaIscritoUsuario.php';

use \es\ucm\fdi\aw\src\Mensajes\Mensaje;
use \es\ucm\fdi\aw\src\Foros\Foro;
use \es\ucm\fdi\aw\src\Profesores\Profesor;
use \es\ucm\fdi\aw\src\Usuarios\Usuario;


if(isset($_POST["id_usuario"]) && isset($_SESSION["rolUser"]) && $_SESSION["rolUser"] == "admin") {
    $id_usuario = $_POST["id_usuario"];
    $usuario = Usuario::buscaPorId($id_usuario);
    
    if($usuario) {
        if(Mensaje::borrarMensajesPorUsuario($id_usuario)) {
            $mensajes[] = 'Mensajes del usuario eliminados correctamente';
        } else {
            $mensajes[] = 'Error al eliminar mensajes del usuario. Por favor, inténtalo de nuevo.';
        }
        if(Foro::eliminarForosPorIdAutor($id_usuario)) {
            $mensajes[] = 'Foros del usuario eliminados correctamente';
        } else {
            $mensajes[] = 'Error al eliminar foros del usuario. Por favor, inténtalo de nuevo.';
        }
        if($usuario->getrolUser() == Usuario::USER_ROLE) {
            if(Profesor::eliminaAlumnos($id_usuario)) {
                $mensajes[] = 'Relaciones alumno-profesor eliminadas correctamente';
            } else {
                $mensajes[] = 'Error al eliminar relaciones alumno-profesor. Por favor, inténtalo de nuevo.';
            }
        }
        else if($usuario->getrolUser() == Usuario::TEACHER_ROLE) {
            if(Profesor::deleteAlumnos($id_usuario)) {
                $mensajes[] = 'Relaciones alumno-profesor eliminadas correctamente';
            } else {
                $mensajes[] = 'Error al eliminar relaciones alumno-profesor. Por favor, inténtalo de nuevo.';
            }
        }
        eliminaIscritoUsuario($id_usuario);
        if($resultado = Usuario::eliminarSiguiendorPorIdUsuario($id_usuario)) {
            $mensajes[] =  'Se han eliminado todas las relaciones de seguimiento para el usuario con ID $idUsuario.';
        } else {
            $mensajes[] =  'Ha ocurrido un error al intentar eliminar las relaciones de seguimiento para el usuario con ID $idUsuario.';
        }
        if($resultado = Usuario::eliminarSeguirPorIdUsuario($id_usuario)) {
            $mensajes[] =  'Se han eliminado todas las relaciones de seguimiento para el usuario con ID $idUsuario.';
        } else {
            $mensajes[] =  'Ha ocurrido un error al intentar eliminar las relaciones de seguimiento para el usuario con ID $idUsuario.';
        }

        $usuarioEliminado = Usuario::ocultaUsuario($id_usuario);    
            if($usuarioEliminado) {
                $mensajes = ['Usuario eliminado correctamente'];
            } else {
                $mensajes = ['Hubo un error al eliminar el usuario. Por favor, inténtalo de nuevo.'];
            }
    } else {
        $mensajes = ['El usuario no se encontró.'];
    }
    $url = resuelve('usuariosView.php');
    
}
    
else {
    $mensajes = ['Acceso no autorizado.'];
    $url = resuelve('usuarios.php');
}

header("Location: $url");
$app->putAtributoPeticion('mensajes', $mensajes);
exit();
?>
