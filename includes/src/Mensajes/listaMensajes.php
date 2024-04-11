<?php
 use \es\ucm\fdi\aw\src\Mensajes\Mensaje;
 use \es\ucm\fdi\aw\src\usuarios\Usuario;

public function listaMensajes()
{
    $mensajes = Mensajes::listarMensajes();

    $html = "<div class='lista_mensajes'>";

    foreach ($mensajes as $mensaje) {
        $html .= visualizaMensaje($mensaje);
    }

    $html .= "</div>";
    return $html;
}

public function listaMensajesForo()
{
    $mensajes = Mensajes::listarMensajesForo();

    $html = "<div class='lista_mensajes'>";

    foreach ($mensajes as $mensaje) {
        $html .= visualizaMensaje($mensaje);
    }

    $html .= "</div>";
    return $html;
}

public function visualizaMensaje($mensaje) {

    $usuario = Usuario::buscaPorId($mensaje-> getIdEmisor());
    $autor = $usuario->getNombre();
    
    $html = '<div class="mensaje">';
    $html .= '<div class="autor_mensaje">' . $autor . '</div>';
    $html .= '<div class="texto_mensaje">' . $mensaje->getTexto() . '</div>';
    $html .= '</div>';

    return $html;
}


?>
