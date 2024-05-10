<?php

require_once __DIR__.'/../../config.php'; 
use \es\ucm\fdi\aw\src\Mensajes\Mensaje;
use \es\ucm\fdi\aw\src\Usuarios\Usuario;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

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

                //incluir saltos de linea al mensaje si es muy largo
                $texto = $mensaje->getTexto();
                $longitud_por_linea = 110;
                $texto_formateado = '';
                $caracteres_contados = 0;
                for ($i = 0; $i < strlen($texto); $i++) {
                    $texto_formateado .= $texto[$i];
                    $caracteres_contados++;

                    if ($caracteres_contados % $longitud_por_linea == 0) {
                        $texto_formateado .= "\n";
                    }
                }

                $eliminarMensaje = resuelve('/includes/src/Foros/eliminarMensajeForo.php');
                if ($idEmisor === $id_usuario_emisor) {
                    $output .= '<div class="comentarioForoOutgoing">
                                    <div class="avatarComentarioForo">
                                        <img src="'. $autor->getAvatar() .'" alt="Avatar">
                                    </div>
                                    <div class="contenidoComentarioForo">
                                        <div class="autorComentarioForo">'. $autor->getNombre() .'</div>
                                        <div class="fechaComentarioForo">'. $mensaje->getFechaYHora() .'</div>
                                        <div class="textoComentarioForo">
                                            <p>'. $texto_formateado .'</p>
                                        </div>';
                    if (isset($_SESSION["rolUser"]) && $_SESSION["rolUser"] == "admin") {
                        $output .= '<form class="eliminar-foro" action="' . $eliminarMensaje . '" method="post" style="float: right;">
                                        <input type="hidden" name="id_foro" value="' . $idForo . '">
                                        <input type="hidden" name="id_mensaje" value="' . $mensaje->getId() . '">
                                        <button type="submit" style="background:none; border:none; padding:0; font-size:inherit; cursor:pointer;">
                                            🗑️
                                        </button>
                                    </form>';
                    }
                                        
                    $output .=      '</div>
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
                                            <p>'. $texto_formateado .'</p>
                                        </div>';
                    if (isset($_SESSION["rolUser"]) && $_SESSION["rolUser"] == "admin") {
                        $output .= '<form class="eliminar-foro" action="' . $eliminarMensaje . '" method="post" style="float: right;">
                                        <input type="hidden" name="id_foro" value="' . $idForo . '">
                                        <input type="hidden" name="id_mensaje" value="' . $mensaje->getId() . '">
                                        <button type="submit" style="background:none; border:none; padding:0; font-size:inherit; cursor:pointer;">
                                            🗑️
                                        </button>
                                    </form>';
                    }
                    $output .=   '</div>
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
