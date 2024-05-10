<?php
require_once __DIR__.'/../../config.php';

use \es\ucm\fdi\aw\src\Mensajes\Mensaje;
use \es\ucm\fdi\aw\src\Foros\Foro;
use \es\ucm\fdi\aw\src\Usuarios\Usuario;
use \es\ucm\fdi\aw\src\BD;
function forosDestacados()
{
    $mensajes = Mensaje::obtenerDosMensajesForoDiferente();
    
    $html = '<h2>Foros Destacados</h2>' ;
    foreach ($mensajes as $mensaje) {
        $idForo = $mensaje->getIdForo();
        $foro = Foro::buscaForo($idForo);
        $html .= foroDestacadoVisualizado($foro, $mensaje);
       

    }
    return $html;
}

function foroDestacadoVisualizado($foro, $mensaje)
{ 
    $html = '<div class="custom-foro-destacado">';
    
    $app = BD::getInstance();
    $usuarioLogueado = $app->usuarioLogueado();    
    
    $rutaForo = resuelve('/includes/vistas/helpers/ForoView.php?id=' . $foro->getId());
    $idForo = $mensaje->getIdForo();

    $autor = $mensaje->getIdEmisor();
    $usuario = Usuario::buscaPorId($autor);
    $nombreAutor = $usuario ? $usuario->getNombre() : "Desconocido";
    $rutaImagen = resuelve('/');
    $avatar = $usuario ? $usuario->getAvatar() : "default_avatar.jpg";
    $avatarImagen =  RUTA_IMGS . $avatar;

    $html .= '<div class="custom-foro-info">';
    $html .= '<div class="custom-avatar"><img src="' .  $avatarImagen. '" alt="Avatar"></div>';
    $html .= '<div class="custom-info-text">';
    $html .= '<p class="custom-nombre">' . $nombreAutor . '</p>';
    $html .= '<p class="custom-texto">' . $mensaje->getTexto() . '</p>';
    $html .= '</div>';
    $html .= '</div>'; 

    // Si el usuario está logueado, envuelve el contenido del foro dentro de un formulario
    if ($usuarioLogueado) {
        $html .= '<form action="' . $rutaForo . '" method="post">';
        $html .= '<input type="hidden" name="id" value="' . $idForo . '">';
        $html .= '<button type="submit" class="custom-button-foro" style="background-color: #4CAF50; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">' . $foro->getTitulo() . '</button>';
        $html .= '</form>';
    }

    $html .= '</div>'; // Cierre de custom-foro-destacado

    return $html;
}

