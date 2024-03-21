
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
    $html .= '<a href="/G3_SW/Evento.php?id_evento=' . $evento->getIdEvento() . '">';
    $html .= '<div class="producto_nombre">' . $evento->getNombre() . '</div>';


    return $html;
}
?>
<?php


    require_once __DIR__.'/Evento.php';
    require_once __DIR__.'/../../config.php';
    require_once __DIR__.'../../../../caracteristicaProducto.php';

    $tituloPagina = 'Eventos';
    $contenidoPrincipal = listaEventos();

?> 


