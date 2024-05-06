<?php
use \es\ucm\fdi\aw\src\Eventos\Evento;

function eventossDestacados()
{
    $eventos = Evento::listarEventos(); 
    
    $html = <<<HTML
    <div class="eventos-destacados">
        <h1>Eventos destacados</h1>
        <div class="contenedor-eventos">
    HTML;
    $rutaCaract = resuelve('/includes/src/Eventos/caracteristicasEvento.php'); 

    foreach ($eventos as $evento) {
        $html .= <<<HTML
        <div class="evento-custom">
            <h2>{$evento->getNombre()}</h2>
            <div class="custom-descripcion-evento">
                <p>{$evento->getDescripcion()}</p>
            </div>
            <p class="premio">Premio: {$evento->getPremio()}</p>
            <a href="{$rutaCaract}?id={$evento->getId()}" class="boton-evento">Ver más</a>
        </div> 
        HTML;
        
    }

    $html .= <<<HTML
                <div class="navegacion-eventos">
                    <button class="flecha-izquierda-evento" onclick="cambiarEvento(-1)">&#8592;</button>
                    <button class="flecha-derecha-evento" onclick="cambiarEvento(1)">&#8594;</button>
                </div> 
            </div> 
        </div> 
        HTML;

    $rutaJs = resuelve('js/cambioEvento.js');
    $html .= "<script src='$rutaJs'></script>";

    return $html;
}
?>
