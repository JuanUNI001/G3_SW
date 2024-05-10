<?php
use es\ucm\fdi\aw\src\Usuarios\Evento;
use es\ucm\fdi\aw\src\BD;


function visualizaEvento($evento)
{

    $rutaCaract = resuelve('/includes/src/Eventos/caracteristicasEvento.php'); 

    $html = <<<EOF
    <div class="evento_container">
        <div class="evento_info_container">
            <div class="evento_nombre"><strong>Nombre:</strong> {$evento->getEvento()}</div>
            <div class="separator_horizontal"></div> <!-- Separador horizontal -->
            <div class="evento_estado"><strong>Estado:</strong> {$evento->getEstado()}</div>
            <div class="evento_categoria"><strong>Categoria:</strong> {$evento->getCategoria()}</div>
            <form action="{$rutaCaract}" method="post">
                <input type="hidden" name="id" value="{$evento->getId()}">
                <button type="submit" class="button-evento">Informacion</button>
            </form>
        </div>
        </div> 
    EOF;

    return $html;
}