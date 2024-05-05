<?php
require_once __DIR__.'/../../config.php';

use \es\ucm\fdi\aw\src\Mensajes\Mensaje;
use \es\ucm\fdi\aw\src\Foros\Foro;
use \es\ucm\fdi\aw\src\BD;
function forosDestacados()
{
    $mensajes = Mensaje::obtenerDosMensajesForoDiferente();
    $html = '<div class="custom-foros-destacados">';
    $html .= '<h2>Foros Destacados</h2>' ;
    foreach ($mensajes as $mensaje) {
        $idForo = $mensaje->getIdForo();
        $foro = Foro::buscaForo($idForo);
        $html .= foroDestacadoVisualizado($foro, $mensaje);
       

    }
    return $html;
}

function foroDestacadoVisualizado($foro, $mensaje)
{ 
    $app = BD::getInstance();
    $usuarioLogueado = $app->usuarioLogueado();

    $rutaForo = resuelve('ForoView.php');
    $idForo = $foro->getId();
    $autorId = $mensaje->getIdEmisor(); 

    $autor = \es\ucm\fdi\aw\src\Usuarios\Usuario::buscaPorId($autorId);
    $nombreAutor = $autor ? $autor->getNombre() : "Desconocido";
   
    $html = <<<EOF
    <div class="custom-foro-destacado">
        <div class="custom-foro-info">
            <div class="custom-foro-titulo">
                <strong>{$foro->getTitulo()}</strong> 
            </div>
            <div class="custom-foro-contenido">
                <div class="custom-foro-descripcion">
                    <p class="custom-foro-autor">{$nombreAutor}</p>
                    
                    <p>{$mensaje->getTexto()}</p>   
                    
                </div>
                
            </div>
        
    EOF;

       
        
    if ($usuarioLogueado) {
        $html .= <<<EOF
            <form action="{$rutaForo}" method="post">
                <input type="hidden" name="id" value="{$idForo}">
                <button type="submit" class="custom-button-foro" style="background-color: #4CAF50; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">Acceder</button>
            </form>
        EOF;    
    }
        
        
    $html .= '</div></div>'; // Cierre de las etiquetas div de custom-foro-info y custom-foro
        
    return $html;
}


?>