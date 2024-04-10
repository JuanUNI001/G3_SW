<?php

    use es\ucm\fdi\aw\src\Eventos\Evento;
    require_once __DIR__.'/../../config.php';


    $tituloPagina = 'Eventos';
    $contenidoPrincipal = listaEventos();

?> 


<?php


function listaeventos()
{
    $eventos = Evento::listarEventos();

    $html = "<div class='eventos'>";

    foreach ($eventos as $evento) {
        $html .= visualizaEvento($evento);
    }

    $html .= "</div>";
    return $html;
}

function visualizaEvento($evento)
{

    $html = '<div class="Evento">';

    $estado = $evento->getEstado();
    $html .= '<div>';
    $rutaCaract = resuelve('/includes/src/Eventos/caracteristicasEvento.php'); 
    $html .= '<a href="'.$rutaCaract.'?id=' . $evento->getId() . '">';

    $html .= '<fieldset>';
    $html .= '<legend>' . $evento->getEvento() . '</legend>';
    $html .= '<p>' . $evento->getEstado() . '</p>';
    $html .= '<ul>';
    $html .= '<li>' . $evento->getCategoria() . '</li>';

    $html .= '</ul>';
    $html .= '</fieldset>';


    $html .= '</div>';


    $html .= '</div>';


    return $html;
}

?>



