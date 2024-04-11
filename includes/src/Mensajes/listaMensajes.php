<?php
 use \es\ucm\fdi\aw\src\Mensajes\Mensaje;

function listaMensajes()
{
    $foros = Mensajes::listarMensajes();

    $html = "<div class='mensajes'>";

    foreach ($mensajes as $mensaje) {
        $html .= visualizaForo($mensaje);
    }

    $html .= "</div>";
    return $html;
}

function visualizaForo($mensaje) {

    $html = '<div class="mensaje">';
    $html .= '<div class="autor_mensaje">' . $foro->getTitulo() . '</div>';
    $html .= '<div class="foro_autor">' . $foro->getTitulo() . '</div>';
    
    $html .= '</a>';
    $html .= '</div>';

    return $html;
}


?>
