<?php

require_once __DIR__.'/../../config.php'; 

use \es\ucm\fdi\aw\src\Mensajes\Mensaje;
use \es\ucm\fdi\aw\src\Usuarios\Usuario;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idEmisor = isset($_POST['idEmisor']) ? $_POST['idEmisor'] : null;
    $idForo = isset($_POST['idDestinatario']) ? $_POST['idDestinatario'] : null;

    $textoMensaje = isset($_POST['message']) ? $_POST['message'] : null;


    // Creamos el objeto Mensaje
    $mensaje = Mensaje::crea(null, $idEmisor, -1, $idForo, $textoMensaje);

    // Guardamos el mensaje en la base de datos
    $mensaje && $mensaje->guarda()
    
}
?>
