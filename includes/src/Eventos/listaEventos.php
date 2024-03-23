
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

function visualizaEvento($evento, $tipo = null)
{
    $html = '<div class="Evento">';
    //$html .= '<a href="/G3_SW/eventos.php?id_evento=' . $evento['id'] . '">';
    //$html .= '<div class="Evento_imagen">';
    //$html .= '</div>';
    //$html .= '<div class="Evento_nombre">' . $evento['nombreTorneo'] . '</div>';
    //$html .= '<div class="Evento_descripcion">' . $evento['descripcionEvento'] . '</div>';
    //$html .= '</a>';
    //$html .= '</div>';

    return $html;
}

?>
<?php


    require_once __DIR__.'/eventos.php';
    require_once __DIR__.'/../../config.php';
   

    $tituloPagina = 'Eventos';
    $contenidoPrincipal = listaEventos();

?> 


