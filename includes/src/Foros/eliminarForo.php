<?php
require_once __DIR__.'/../../config.php';

use \es\ucm\fdi\aw\src\Foros\Foro;
use \es\ucm\fdi\aw\src\Mensajes\Mensaje;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if(isset($_POST["id_foro"])&& isset($_SESSION["rolUser"]) && $_SESSION["rolUser"] == "admin") {
        
        $id_foro = $_POST["id_foro"];
        $foro = Foro::buscaForo($id_foro);
        
        if($foro) {
            $mensajesForo = Mensaje::GetMensajesInForoChat($id_foro);
            
            foreach ($mensajesForo as $mensaje) {
                $id_mensaje = $mensaje->getId();
                Mensaje::borraPorId($id_mensaje);
            
            }
            $foroEliminado = Foro::borraPorId($id_foro);    
                if($foroEliminado) {
                    $mensajes = ['Foro eliminado correctamente'];
                } else {
                    $mensajes = ['Hubo un error al eliminar el for. Por favor, inténtalo de nuevo.'];
                }
        } else {
            $mensajes = ['El foro no se encontró.'];
        }
        
    }
        
    else {
        $mensajes = ['Acceso no autorizado.'];
        
    }
}
$url .= resuelve('foros.php');

header("Location: $url");
$app->putAtributoPeticion('mensajes', $mensajes);
exit();
?>