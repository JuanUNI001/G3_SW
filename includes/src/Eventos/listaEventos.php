
<?php


function listaeventos()
{
    $eventos = Evento::listarEventos();

    $html = "<div class='productos'>";

    foreach ($eventos as $evento) {
        $html .= visualizaEvento($evento);
    }

    $html .= "</div>";
    return $html;
}

function visualizaEvento($evento, $tipo = null)
{
    $html = '<div class="Evento">';
    //$html .= '<a href="/G3_SW/eventos.php?id_evento=' . $evento->getIdEvento() . '">';
   // $html .= '<div class="producto_nombre">' . $evento->getNombreTorneo() . '</div>';


    return $html;
}
?>
<?php


    require_once __DIR__.'/eventos.php';
    require_once __DIR__.'/../../config.php';
   

    $tituloPagina = 'Eventos';
    $contenidoPrincipal = listaEventos();

?> 


