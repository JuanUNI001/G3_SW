<?php
require_once __DIR__.'/../../config.php';

use \es\ucm\fdi\aw\src\Mensajes\Mensaje;


if(isset($_POST["id_mensaje"]) &&isset($_POST["id_foro"])&& isset($_SESSION["rolUser"]) && $_SESSION["rolUser"] == "admin") {
    $id_mensaje = $_POST["id_mensaje"];
    $id_foro = $_POST["id_foro"];
    $mensaje = Mensaje::buscaPorId($id_mensaje);
    
    if($mensaje) {
        $mensajeEliminado = Mensaje::borraPorId($id_mensaje);    
            if($mensajeEliminado) {
                $mensajes = ['Mensaje eliminado correctamente'];
            } else {
                $mensajes = ['Hubo un error al eliminar el mensaje del foro. Por favor, inténtalo de nuevo.'];
            }
    } else {
        $mensajes = ['El mensaje del foro no se encontró.'];
    }
    $rutaForo = resuelve('/includes/vistas/helpers/ForoView.php');
    $url .= $rutaForo . '?id_foro=' . $id_foro;
}
    
else {
    $mensajes = ['Acceso no autorizado.'];
    $url .= resuelve('foros.php');
}


header("Location: $url");
$app->putAtributoPeticion('mensajes', $mensajes);
exit();
?>