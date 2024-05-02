<?php

require_once __DIR__.'/../../config.php'; 

use \es\ucm\fdi\aw\src\Mensajes\Mensaje;
use \es\ucm\fdi\aw\src\Usuarios\Usuario;

error_log("Error al enviar el mensaje.");
echo("Error al enviar el mensaje.");
    $idEmisor = isset($_POST['idEmisor']) ? $_POST['idEmisor'] : null;
    $idForo = isset($_POST['idForo']) ? $_POST['idForo'] : null;
    echo("Error al enviar el mensaje.");
    $textoMensaje = isset($_POST['message']) ? $_POST['message'] : null;


    // Creamos el objeto Mensaje
    $mensaje = Mensaje::crea(null, $idEmisor, -1, $idForo, $textoMensaje);

    // Guardamos el mensaje en la base de datos
    $mensaje && $mensaje->guarda()
    

?>
