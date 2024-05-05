<?php

require_once __DIR__.'/../../config.php'; 
use \es\ucm\fdi\aw\src\Mensajes\Mensaje;
use \es\ucm\fdi\aw\src\Usuarios\Usuario;

// Obtener el ID del usuario receptor de la solicitud POST
$idForo = isset($_POST['incoming_id']) ? $_POST['incoming_id'] : null;

if ($idForo !== null) {
    $usuario_emisor = Usuario::buscaUsuario($_SESSION['correo']);
    $id_usuario_emisor = $usuario_emisor->getId();
    $mensajes = Mensaje::GetMensajesInForoChat($idForo);
    $output = '';
    if (!empty($mensajes)) {
        

        foreach ($mensajes as $mensaje) {
            $idEmisor = $mensaje->getIdEmisor();
            $autor = Usuario::buscaPorId($idEmisor);

            if ($idEmisor === $id_usuario_emisor) {
                $output .= '<div class="comentarioForoOutgoing">
                                <div class="avatarComentarioForo">
                                    <img src="'. $autor->getAvatar() .'" alt="Avatar">
                                </div>
                                <div class="contenidoComentarioForo">
                                    <div class="autorComentarioForo">'. $autor->getNombre() .'</div>
                                    <div class="fechaComentarioForo">'. $mensaje->getFechaYHora() .'</div>
                                    <div class="textoComentarioForo">
                                        <p>'. $mensaje->getTexto() .'</p>
                                    </div>
                                </div>
                            </div>';
               
            } else {
                // El mensaje es entrante (del usuario receptor)

                $output .= '<div class="comentarioForoIncoming">
                                <div class="avatarComentarioForo">
                                    <img src="'. $autor->getAvatar() .'" alt="Avatar">
                                </div>
                                <div class="contenidoComentarioForo">
                                    <div class="autorComentarioForo">'. $autor->getNombre() .'</div>
                                    <div class="fechaComentarioForo">'. $mensaje->getFechaYHora() .'</div>
                                    <div class="textoComentarioForo">
                                        <p>'. $mensaje->getTexto() .'</p>
                                    </div>
                                </div>
                            </div>';
            }
        }
        echo $output;
    } else {
        // Si no se encontraron mensajes, devolver un objeto JSON vacío
        echo $output;
    }
} else {
    // Si no se proporcionó un ID de usuario receptor válido, devolver un objeto JSON vacío
    echo $output;
}

?>
