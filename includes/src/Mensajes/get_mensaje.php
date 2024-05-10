<?php

require_once __DIR__.'/../../config.php'; 
use \es\ucm\fdi\aw\src\Mensajes\Mensaje;
use \es\ucm\fdi\aw\src\Usuarios\Usuario;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_usuario_receptor = isset($_POST['incoming_id']) ? $_POST['incoming_id'] : null;

    if ($id_usuario_receptor !== null) {
        $usuario_emisor = Usuario::buscaUsuario($_SESSION['correo']);
        $id_usuario_emisor = $usuario_emisor->getId();
        $mensajes = Mensaje::GetMensajesInPrivateChat( $id_usuario_emisor, $id_usuario_receptor);
        $output = '';
        if (!empty($mensajes)) {
            
            
            foreach ($mensajes as $mensaje) {
                $idEmisor = $mensaje->getIdEmisor();
                if ($idEmisor === $id_usuario_emisor) {
                        $output .= '<div class="chat outgoing">
                        <div class="details">
                            <p>'. $mensaje->getTexto() .'</p>
                        </div>
                    </div>';
                
                } else {
                    // El mensaje es entrante (del usuario receptor)
                    $output .= '<div class="chat incoming">
                                    <div class="details">
                                        <p>'. $mensaje->getTexto() .'</p>
                                    </div>
                                </div>';
                }
            }
            echo $output;
        } else {
            echo $output;
        }
    } else {
        echo $output;
    }
}
else {
    echo $output;
}
?>
