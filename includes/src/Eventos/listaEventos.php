<?php

    use es\ucm\fdi\aw\src\Eventos\Evento;
    require_once __DIR__.'/../../config.php';
    require_once __DIR__.'/visualizaEvento.php';

    $tituloPagina = 'Eventos';
    $contenidoPrincipal = listaEventos();

?> 


<?php


function listaeventos()
{
    $eventos = Evento::listarEventos();

    $html = '<div class="eventos">';

    foreach ($eventos as $evento) {
        $html .= visualizaEvento($evento);
    }

    $html .= "</div>";
    return $html;
}
function listaeventosBusqueda($buscar, $buscaPrecioDesde, $buscaPrecioHasta, $fechaDesde, $fechaHasta, $orden, $categoria, $estado)
{
    $eventos = Evento::listaEventosBusqueda($buscar, $buscaPrecioDesde, $buscaPrecioHasta, $fechaDesde, $fechaHasta, $orden, $categoria, $estado);

    $html = '<div class="eventos">';

    foreach ($eventos as $evento) {
        $html .= visualizaEvento($evento);
    }

    $html .= "</div>";
    return $html;
}

?>



